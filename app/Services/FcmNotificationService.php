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

public function sendNotification(array|string $tokensOrTopic, string $title, string $body, array $data = [], ?string $image = null, string $type = 'tokens')
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
    'user_id' => $userId ?? null,
    'title' => $title,
    'body' => $body,
    'type' => $type,
    'data' => "",
    "is_read"=>0,
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
 