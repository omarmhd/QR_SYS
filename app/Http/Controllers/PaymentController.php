<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Uri\Http;

class PaymentController extends Controller
{
    public function startPayment(Request $request)
    {

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => '5XP6-X98D-3GNH-G5PV-W8LH'
        ])->post('https://secure.sandbox.netopia-payments.com/payment/card/start', [
            "config" => [
                "emailTemplate" => "confirm",
                "notifyUrl" => "/",
                "redirectUrl" => "/",
                "language" => "ro"
            ],
            "payment" => [
                "options" => [
                    "installments" => 1,
                    "bonus" => 0
                ],
                "instrument" => [
                    "type" => "card",
                    "account" => "9900004810225098",
                    "expMonth" => 1,
                    "expYear" => 2023,
                    "secretCode" => "111",
                    "token" => ""
                ],
                "data" => [
                    "BROWSER_USER_AGENT" => request()->userAgent(),
                    "IP_ADDRESS" => request()->ip(),
                    // أضف باقي بيانات الجهاز إذا أحببت
                ]
            ],
            "order" => [
                "posSignature" => "RAND-OM01-SIGN-TURE-3POS",
                "dateTime" => now()->toIso8601String(),
                "description" => "Order Desc",
                "orderID" => "stringOrderID4694",
                "amount" => 200,
                "currency" => "RON",
                "billing" => [
                    "email" => "user@example.com",
                    "firstName" => "string",
                    "lastName" => "string",
                    "city" => "string",
                    "country" => 0
                ],
                "shipping" => [
                    "email" => "user@example.com",
                    "firstName" => "string",
                    "lastName" => "string",
                    "city" => "string",
                    "country" => 0
                ],
                "products" => [
                    [
                        "name" => "string",
                        "code" => "string",
                        "category" => "string",
                        "price" => 0,
                        "vat" => 0
                    ]
                ]
            ]
        ]);

        $data = $response->json();
        // توجيه المستخدم لصفحة الدفع
        return redirect($data['payment_url'] ?? '/');

    }
}
