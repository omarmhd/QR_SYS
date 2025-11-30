<?php

namespace App\Services;

use App\Models\Notification as ModelsNotification;
use Google\Client;
use Illuminate\Support\Str;
use Modules\Notifications\Entities\Notification;

class FcmNotificationService
{
    protected $client;

    public function __construct()
    {
     $serviceAccountPath = storage_path('app/' . env('FIREBASE_CREDENTIALS_PATH'));


        $this->client = new Client();
        $this->client->setAuthConfig($serviceAccountPath);
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    protected function getAccessToken(): string
    {
        $token = $this->client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }
/*
public function sendNotification(array|string $tokensOrTopic, string $title, string $body, array $data = [], ?string $image = null, string $type = 'tokens',$user_id=null)
{
    $accessToken = $this->getAccessToken();



  if ($type === 'tokens') {


    $responses = [];

    foreach ($tokensOrTopic as $token) {
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ],
        ];

        if ($image) {
            $payload['message']['notification']['image'] = $image;
        }

        $response = $this->send($payload, $accessToken);
        $responses[] = json_decode($response, true);
    }
    }else{
          $payload = [
            'message' => [
                'topic' => $tokensOrTopic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ],
        ];
                $response = $this->send($payload, $accessToken);
        $responses[] = json_decode($response, true);


    }



    if (isset($responses[0]['name'])) {


    ModelsNotification::create([
    'user_id' => $user_id ?? null,
    'title' => $title,
    'body' => $body,
    'type' => $type,
    'data' => null,
    "is_read"=>0,
    'sent_at' => now(),
]);


    }
    return $responses;
}
  */

//    public function sendNotification(
//        array|string $tokensOrTopic,
//        array $title,
//        array $body,
//        array $data = [],
//        ?string $image = null,
//        string $type = 'tokens',
//        $user_id = null
//    ) {
//        $accessToken = $this->getAccessToken();
//        $responses = [];
//
//        // tray notification – language default EN
//        $titleDefault = $title['en'] ?? reset($title);
//        $bodyDefault  = $body['en'] ?? reset($body);
//
//        // convert all languages into string (mandatory for Firebase)
//        $data['languages'] = json_encode([
//            'title' => $title,
//            'body'  => $body,
//        ], JSON_UNESCAPED_UNICODE);
//
//        // payload base
//        $payloadBase = [
//            'notification' => [
//                'title' => $titleDefault,
//                'body'  => $bodyDefault,
//            ],
//            'data' => $data,
//        ];
//
//        if ($image) {
//            $payloadBase['notification']['image'] = $image;
//        }
//
//        if ($type === 'tokens' && is_array($tokensOrTopic)) {
//
//            foreach ($tokensOrTopic as $token) {
//                $payload = [
//                    'message' => array_merge($payloadBase, [
//                        'token' => $token
//                    ])
//                ];
//
//                $response = $this->send($payload, $accessToken);
//                $responses[] = json_decode($response, true);
//            }
//
//        } else {
//            // sending topic
//            $payload = [
//                'message' => array_merge($payloadBase, [
//                    'topic' => $tokensOrTopic
//                ])
//            ];
//
//            $response = $this->send($payload, $accessToken);
//            $responses[] = json_decode($response, true);
//        }
//
//        // save to DB
//        if (isset($responses[0]['name'])) {
//            ModelsNotification::create([
//                'user_id' => $user_id,
//                'title'   => json_encode($title, JSON_UNESCAPED_UNICODE),
//                'body'    => json_encode($body, JSON_UNESCAPED_UNICODE),
//                'type'    => $type,
//                'data'    => json_encode($data, JSON_UNESCAPED_UNICODE),
//                'is_read' => 0,
//                'sent_at' => now(),
//            ]);
//        }
//
//        return $responses;
//    }

    public function sendNotification(
        array|string $tokensOrTopic,
        array|string $title, // تم السماح باستقبال نص أو مصفوفة
        array|string $body,  // تم السماح باستقبال نص أو مصفوفة
        array $data = [],
        ?string $image = null,
        string $type = 'tokens',
        $user_id = null
    ) {
        $accessToken = $this->getAccessToken();
        $responses = [];

        // 1. معالجة العنوان (Title Processing)
        if (is_array($title)) {
            // إذا كان مصفوفة نأخذ الإنجليزي أو أول عنصر
            $titleDefault = $title['en'] ?? reset($title);
            // نجهز المصفوفة للحفظ كـ JSON
            $titleData = $title;
        } else {
            // إذا كان نصاً نستخدمه مباشرة
            $titleDefault = $title;
            // نحوله لمصفوفة لتوحيد شكل البيانات في الـ data والـ DB
            $titleData = ['en' => $title];
        }

        // 2. معالجة المحتوى (Body Processing)
        if (is_array($body)) {
            $bodyDefault = $body['en'] ?? reset($body);
            $bodyData = $body;
        } else {
            $bodyDefault = $body;
            $bodyData = ['en' => $body];
        }

        // 3. تجهيز بيانات اللغات للـ Payload
        // نقوم بترميز المصفوفات الموحدة التي أنشأناها في الخطوات السابقة
        $data['languages'] = json_encode([
            'title' => $titleData,
            'body'  => $bodyData,
        ], JSON_UNESCAPED_UNICODE);

        // payload base
        $payloadBase = [
            'notification' => [
                'title' => $titleDefault, // النص الظاهر في الإشعار
                'body'  => $bodyDefault,  // المحتوى الظاهر في الإشعار
            ],
            'data' => $data,
        ];

        if ($image) {
            $payloadBase['notification']['image'] = $image;
        }

        // إرسال الإشعار (نفس المنطق السابق)
        if ($type === 'tokens' && is_array($tokensOrTopic)) {
            foreach ($tokensOrTopic as $token) {
                $payload = [
                    'message' => array_merge($payloadBase, [
                        'token' => $token
                    ])
                ];

                $response = $this->send($payload, $accessToken);
                $responses[] = json_decode($response, true);
            }
        } else {
            // sending topic
            $payload = [
                'message' => array_merge($payloadBase, [
                    'topic' => $tokensOrTopic
                ])
            ];

            $response = $this->send($payload, $accessToken);
            $responses[] = json_decode($response, true);
        }

        // save to DB
        if (isset($responses[0]['name'])) {
            ModelsNotification::create([
                'user_id' => $user_id,
                // نقوم بحفظ النسخة الـ JSON دائماً لتوحيد البيانات في قاعدة البيانات
                'title'   => json_encode($titleData, JSON_UNESCAPED_UNICODE),
                'body'    => json_encode($bodyData, JSON_UNESCAPED_UNICODE),
                'type'    => $type,
                'data'    => json_encode($data, JSON_UNESCAPED_UNICODE),
                'is_read' => 0,
                'sent_at' => now(),
            ]);
        }

        return $responses;
    }

    protected function send(array $payload, string $accessToken)
    {
        $ch = curl_init('https://fcm.googleapis.com/v1/projects/' . env('FIREBASE_PROJECT_ID') . '/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


}
