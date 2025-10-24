<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NetopiaPaymentService
{
    protected string $apiUrl;
    protected string $apiKey;
    protected string $posSignature;
    protected string $notifyUrl;
    protected string $redirectUrl;
    protected $firebaseService;


    public function __construct(FcmNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;

        $this->apiUrl = config('services.netopia.url');
        $this->apiKey = config('services.netopia.api_key');
        $this->posSignature = config('services.netopia.pos_signature');
    }

    public function startPayment(Request $request, $user)
    {
        $plan = Plan::findOrFail($request->plan_id);
        $amount = $request->total;
        $orderId = 'ORD-' . time();



        try {
            DB::beginTransaction();

            $payment = Payment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'order_id' => $orderId,
                'payment_method' => "$request->payment_method",
                'billing_type' => "$request->billing_type",
                'billing_name' => "$request->billing_name",
                'billing_email' => "$request->billing_email",
                'billing_phone' => "$request->billing_phone",
                'billing_address' => "$request->billing_address",
                'amount' => $amount,
                'status' => 'pending'
            ]);


            $payload = [
                "config" => [
                    "emailTemplate" => "confirm",
                    "notifyUrl" => url('/api/payment/notify'),
                    "redirectUrl" => "",
                    "language" => "en"
                ],
                "payment" => [
                    "options" => ["installments" => 1, "bonus" => 0],
                    "data" => [
                        "BROWSER_USER_AGENT" => $request->header('User-Agent'),
                        "OS" => PHP_OS,
                        "BROWSER_LANGUAGE" => app()->getLocale(),
                        "IP_ADDRESS" => $request->ip()
                    ]
                ],
                "order" => [
                    "posSignature" => $this->posSignature,
                    "dateTime" => now()->toIso8601String(),
                    "description" => "Payment for plan ",
                    "orderID" => "$orderId",
                    "amount" => (float) $amount,
                    "currency" => "EUR",
                    "billing" => [
                        "email" => "$request->billing_email",
                        "phone" => "$request->billing_phone",
                        "firstName" => "$request->billing_name",
                        "lastName" => "$request->billing_name",
                        "city" => "",
                        "state" => "",
                        "postalCode" => "",
                        "details" => "$request->billing_address"
                    ]
                ]
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: ' . $this->apiKey
                ],
            ]);


            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                DB::rollBack();
                return ['status' => 'error', 'message' => $error];
            }

            $data = json_decode($response, true);
            $payment->update(['raw_response' => json_encode($data)]);

            if (!isset($data['payment']["paymentURL"])) {
                DB::rollBack();
                return ['status' => 'error', 'response' => $data];
            }

            DB::commit();

            return [
                'status' => 'success',
                'payment_url' => $data['payment']["paymentURL"],
                'order_id' => $orderId,
                'amount' => $amount,
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }


    public function handleNotification(array $data)
    {
        Log::info('📩 Netopia Notification Received:', $data);

        $payment = Payment::where('order_id', $data['order']['orderID'] ?? $data['orderID'] ?? null)->first();

        ;
        if (!$payment) {
            Log::warning('⚠️ Payment not found for orderID:', ['orderID' => $data['orderID'] ?? null]);
            return ['error' => 'Payment not found'];
        }

        $status = $data['payment']['status'] ?? 'failed';
        $paymentMethod = $data['paymentMethod'] ?? 'card';
        $transactionId = $data['transactionId'] ?? null;

        Log::info('💳 Payment status update attempt:', [
            'order_id' => $payment->order_id,
            'status' => $status,
            'paymentMethod' => $paymentMethod,
            'transactionId' => $transactionId,
        ]);

        $payment->update([
            'status' => (int)$status === 3 ? 'success' : 'failed',
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
            'paid_at' => (int)$status === 3 ? now() : null,
            'raw_callback' => json_encode($data)
        ]);

        Log::info('✅ Payment record updated successfully', [
            'order_id' => $payment->order_id,
            'new_status' => $payment->status
        ]);

        if ((int)$status === 3 ) {
            Log::info('🎉 Payment confirmed as PAID. Activating subscription...', [
                'user_id' => $payment->user_id,
                'plan_id' => $payment->plan_id
            ]);

            $expiresAt = match ($payment->user->plan->billing_type) {
                'day' => now()->addDay(),
                'month' => now()->addMonth(),
                'year' => now()->addYear(),
                default => now()->addMonth(),
            };

            $subscription = $payment->user->subscription()->updateOrCreate(
                ['plan_id' => $payment->plan_id, "user_id" => $payment->user_id],
                ['status' => 'active', 'start_date' => now(), 'end_date' => $expiresAt]
            );

            $user = $payment->user;
            $user->update([
                'current_subscription' => $subscription->id,
                'subscription_status' => 1,
                'plan_id' => $payment->plan_id
            ]);

            Log::info('🆕 Subscription activated', [
                'subscription_id' => $subscription->id,
                'expires_at' => $expiresAt
            ]);

            $tokens = $user->deviceTokens->pluck('fcm_token')->filter()->toArray();
            if ($tokens) {
                $title = 'Payment Successful!';
                $body = "Congratulations! Your subscription is now active. It will expire on " . $expiresAt->format('F j, Y') . ".";
                $this->firebaseService->sendNotification(
                    $tokens,
                    $title,
                    $body,
                    ['type' => 'subscription_update'],
                    null,
                    'tokens',
                    $user->id
                );

                Log::info('📱 FCM notification sent to user', [
                    'user_id' => $user->id,
                    'tokens_count' => count($tokens)
                ]);
            } else {
                Log::info('ℹ️ No device tokens found for user', ['user_id' => $user->id]);
            }
        } else {
            Log::warning('❌ Payment status not paid', [
                'order_id' => $payment->order_id,
                'status' => $status
            ]);
        }

        Log::info('🔚 Netopia notification processing finished', ['order_id' => $payment->order_id]);
        return ['message' => 'Notification processed'];
    }
}
