<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Uri\Http;

class PaymentController extends Controller
{

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
                    "description" => "Payment for plan ",
                    "orderID" => $orderId,
                    "amount" => (float) $amount,
                    "currency" => "EUR",
                    "billing" => [
                        "email" => $request->billing_email,
                        "phone" => $request->billing_phone,
                        "firstName" => $request->billing_name,
                        "lastName" => $request->billing_name,
                        "city" => "",
                        "state" => "",
                        "postalCode" => "",
                        "details" => $request->billing_address ?? ""
                    ]]
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
                DB::rollBack();
                return response()->json(['error' => $error], 500);
            }

            $data = json_decode($response, true);

            $payment->update(['raw_response' => json_encode($data)]);


            if (!isset($data['payment']["paymentURL"])) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'response' => $data]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'payment_url' => $data['payment']["paymentURL"],
                'order_id' => $orderId,
                'amount' => $amount,
            ]);


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
