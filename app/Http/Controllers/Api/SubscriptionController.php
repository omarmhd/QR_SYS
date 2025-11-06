<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Services\{FcmNotificationService,NetopiaPaymentService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    protected $firebaseService;
    protected $paymentService;

    public function __construct(FcmNotificationService $firebaseService,NetopiaPaymentService $netopiaPaymentService)
    {
        $this->firebaseService = $firebaseService;
        $this->paymentService=$netopiaPaymentService;
    }
    /*
    public function startPayment(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_type' => 'required|in:personal,company',
            'payment_method' => 'required|in:card,apple_pay,bank_transfer',
            'billing_name' => 'required|string',
            'billing_email' => 'required|email',
            'billing_phone' => 'nullable|string',
            'billing_address' => 'nullable|string',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $amount = $plan->price;
        $orderId = 'ORD-' . time();

        $payment = Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'order_id' => $orderId,
            'payment_method' => $request->payment_method,
            'billing_type' => $request->billing_type,
            'billing_name' => $request->billing_name,
            'billing_email' => $request->billing_email,
            'billing_phone' => $request->billing_phone,
            'billing_address' => $request->billing_address,
            'amount' => $amount,
            'status' => 'pending'
        ]);

        // تجهيز بيانات Netopia
        $payload = [
            "config" => [
                "emailTemplate" => "confirm",
                "notifyUrl" => url('/api/payment/notify'),
                "redirectUrl" => url('/api/payment/callback'),
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
                "posSignature" => "2IN0-CUKV-ZRC5-SN9K-W2F1",
                "dateTime" => now()->toIso8601String(),
                "description" => "Payment for plan {$plan->name}",
                "orderID" => $orderId,
                "amount" => $amount,
                "currency" => "EUR",
                "billing" => [
                    "email" => $request->billing_email,
                    "phone" => $request->billing_phone,
                    "firstName" => explode(' ', $request->billing_name)[0],
                    "lastName" => explode(' ', $request->billing_name)[1] ?? '',
                    "city" => "",
                    "country" => "",
                    "state" => "",
                    "postalCode" => "",
                    "details" => $request->billing_address ?? ""
                ],
                "shipping" => [
                    "email" => $request->billing_email,
                    "phone" => $request->billing_phone,
                    "firstName" => explode(' ', $request->billing_name)[0],
                    "lastName" => explode(' ', $request->billing_name)[1] ?? ''
                ],
                "products" => [
                    [
                        "name" => $plan->name,
                        "code" => "PLAN-" . $plan->id,
                        "category" => "Subscription",
                        "price" => $amount,
                        "vat" => 0
                    ]
                ]
            ]
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://secure.sandbox.netopia-payments.com/payment/card/start',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: VdhqYXORwtdDySx4q_69IKcm2H5IZaD1yKdhsTaQTKPoRedvKYaM6mHFXQA='
            ],
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            return response()->json(['error' => $error], 500);
        }

        $data = json_decode($response, true);
        $payment->update(['raw_response' => json_encode($data)]);

        if (isset($data['paymentUrl'])) {
            return response()->json([
                'status' => 'success',
                'payment_url' => $data['paymentUrl'],
                'order_id' => $orderId,
                'amount' => $amount,
            ]);
        }

        return response()->json(['status' => 'error', 'response' => $data]);
    }

    */

    public function checkVatStatus(Request $request)
    {
        $data = [
            [
                'cui' => $request->cui,
                'data' => now()
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            "User-Agent"=>"curl/7.68.0",
            "Accept"=>"application/json"
        ])->post('https://webservicesp.anaf.ro/api/PlatitorTvaRest/v9/tva', $data);

        if ($response->successful()) {
            $result = $response->json();

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $response->body()
        ], $response->status());
    }
    public function startPayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'cui' => 'required_if:billing_type,company',
            'id_number'=>'required_if:billing_type,personal',
            'billing_type' => 'required|in:personal,company',
            'payment_method' => 'required|in:card,apple_pay,bank_transfer',
            'billing_name' => 'required|string',
            'billing_email' => 'required|email',
            'billing_phone' => 'nullable|string',
            'billing_address' => 'nullable|string',
            "total"=>"required|numeric"
        ]);

        $user = auth()->user();
        return response()->json($this->paymentService->startPayment($request, $user));
    }


    public function changePlan(Request $request){
        $request->validate([
            "old_plan"=>"required|exists:plans,id",
            "new_plan"=>"required|exists:plans,id"
        ]);



        $user = auth()->user();
        $subscription = $user->subscription()->where('plan_id', $request->old_plan)->first();
        if (!$subscription) {
            return response()->json([
                "status" => "error",
                "message" => "User is not subscribed to the old plan"
            ], 400);
        }



        $oldPlan = $subscription->plan;
        $newPlan = Plan::find($request->new_plan);

        $totalDays = $subscription->end_date->diffInDays($subscription->start_date);
        $usedDays = now()->diffInDays($subscription->start_date);
        $unusedRatio = ($totalDays - $usedDays) / $totalDays;

        $remainingCredit = $oldPlan->price * $unusedRatio;

        $amountDue = $newPlan->price - $remainingCredit;
        $amountDue = max(0, $amountDue);



        return response()->json([
            "status" => "success",
            "old_plan" => [
                "name" => $oldPlan->name,
                "price" => $oldPlan->price,
                "used_days" => $usedDays,
                "remaining_credit" => $remainingCredit
            ],
            "new_plan" => [
                "name" => $newPlan->name,
                "price" => $newPlan->price
            ],
            "amount_due" => $amountDue
        ]);



    }
    public function switchPlan(Request $request)
    {
        $request->validate([
            "plan_id" => "required|exists:plans,id",
        ]);

        $plan = Plan::find($request->plan_id);
        $user = auth()->user();

        $expiresAt = match ($plan->billing_type) {
            'day' => now()->addDay(),
            'month' => now()->addMonth(),
            'year' => now()->addYear(),
            default => now()->addMonth(),
        };

        $subscription = $user->subscription()->updateOrCreate(
            ["user_id" => $user->id],
            [
                'status' => 'active',
                'start_date' => now(),
                'end_date' => $expiresAt,
                "plan_id" => $plan->id
            ]
        );

        $user->update([
            'current_subscription' => $subscription->id,
            'subscription_status' => 1,
            'plan_id' => $plan->id,
            'plan_name'=>$plan->name,
            "is_sub_cancelled" => 0
        ]);

        Log::info('🆕 Subscription activated', [
            'subscription_id' => $subscription->id,
            'expires_at' => $expiresAt
        ]);

        $tokens = $user->deviceTokens->pluck('fcm_token')->filter()->toArray();
        if (!empty($tokens)) {
            $title = 'Successful!';
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

        return response()->json([
            "status" => true,
            "message" => "Subscription switched successfully.",
            "data" => [
                "plan_name" => $plan?->name,
                "end_date" => $expiresAt->toDateTimeString()
            ]
        ]);
    }


    public function cancelSubscription(){
        $user=auth()->user();
        $status=auth()->user()->update(["is_sub_cancelled"=>1]);
        $tokens = $user->deviceTokens->pluck('fcm_token')->toArray();

        if ($status) {
            app("notification")->sendNotification(
                $tokens,
                'Subscription Update',
                'Your subscription has been canceled.',
                ['type' => 'token'],
                null,
                'tokens',
                $user->id
            );
            return response()->json([
                "status" => true,
                "data"=>[
                    "end_date"=>$user?->subscription?->end_date
                ],
                "message" => "Subscription canceled successfully"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Update failed"
            ]);

    }

    }


    public function notify(Request $request)
    {
        return response()->json($this->paymentService->handleNotification($request->all()));

    }

    public function manualPaymentConfirm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'payment_date' => 'required',
            'payment_type' => 'required|string|max:255',
            'transfer_method' => 'required|string|max:255',
            'confirmation_note' => 'nullable|string|max:500',
        ]);

        $messageBody = "Manual Payment Confirmation\n\n"
            . "Name: {$validated['name']}\n"
            . "Phone: {$validated['phone']}\n"
            . "Email: {$validated['email']}\n"
            . "Payment Date: {$validated['payment_date']}\n"
            . "Payment Type: {$validated['payment_type']}\n"
            . "Transfer Method: ".($validated['transfer_method'] ?? 'Bank')."\n"
            . "Confirmation Note: " . ($validated['confirmation_note'] ?? 'N/A') . "\n\n"
            . "Sent automatically from the system.";

        Mail::raw($messageBody, function ($message) {
            $message->to('jad.rahal@el-unico.ro')
            ->subject('Manual Payment Confirmation');
        });

        return response()->json(['status'=>true,'message' => 'Manual payment confirmation sent successfully.'], 200);
    }
}
