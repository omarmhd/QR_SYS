<?php
//
//namespace App\Services;
//
//use App\Http\Controllers\MembershipController;
//use App\Models\ContactMessage;
//use App\Models\ServiceRequest;
//use App\Models\User;
//use Google\Client;
//use http\Message;
//use Illuminate\Support\Facades\Http;
//use Exception;
//use Illuminate\Support\Facades\Log;
//
//class FirestoreService
//{
//    protected Client $client;
//    protected string $projectId;
//
//    public function __construct()
//    {
//        $this->projectId = env('FIREBASE_PROJECT_ID');
//        $serviceAccountPath = storage_path('app/' . env('FIREBASE_CREDENTIALS_PATH'));
//
//        if (!file_exists($serviceAccountPath)) {
//            Log::error("Firebase credentials file not found at: {$serviceAccountPath}");
//            return;
//        }
//
//        $this->client = new Client();
//        $this->client->setAuthConfig($serviceAccountPath);
//        $this->client->addScope('https://www.googleapis.com/auth/datastore');
//    }
//
//    protected function getAccessToken(): ?string
//    {
//        if (!isset($this->client)) {
//            return null;
//        }
//
//        try {
//            $token = $this->client->fetchAccessTokenWithAssertion();
//            return $token['access_token'] ?? null;
//        } catch (Exception $e) {
//            Log::error("Failed to fetch Firebase Access Token: " . $e->getMessage());
//            return null;
//        }
//    }
//
//
//    public function updateRequestsCountInFirestore(): array
//    {
//        $accessToken = $this->getAccessToken();
//
//        if (!$accessToken) {
//            return ['status' => 'error', 'message' => 'Failed to get access token.'];
//        }
//
//        try {
//            $documentPath = "projects/{$this->projectId}/databases/(default)/documents/requests/requests";
//
//            $newCount = User::where("approval_status", "pending")->count();
//            $countMessages=ContactMessage::count();
//            $vipRequests=ServiceRequest::count();
//
//
//            $payload = [
//                'fields' => [
//                    'count' => [
//                        'integerValue' => (string) $newCount,
//                    ],
//                    "count_messages"=>[
//                        'integerValue' =>  $countMessages,
//
//                    ],
//                    "count_vip"=>[
//                        'integerValue' =>  $vipRequests,
//
//                    ]
//
//                    ,
//                    'last_updated' => [
//                        'timestampValue' => now()->toIso8601String(),
//                    ]
//                ]
//            ];
//
//
//            $url = "https://firestore.googleapis.com/v1/{$documentPath}?updateMask.fieldPaths=count&updateMask.fieldPaths=count_messages&updateMask.fieldPaths=count_vip&updateMask.fieldPaths=last_updated";
//
//            $response = Http::withToken($accessToken)
//                ->patch($url, $payload);
//
//            if ($response->successful()) {
//                return ['status' => 'success', 'data' => $response->json()];
//            } else {
//                Log::error("Firestore Update Failed ({$response->status()}): " . $response->body());
//                return ['status' => 'error', 'message' => 'Firestore update failed.', 'details' => $response->json()];
//            }
//
//        } catch (Exception $e) {
//            Log::error("Exception during Firestore Update: " . $e->getMessage());
//            return ['status' => 'error', 'message' => $e->getMessage()];
//        }
//    }
//}


namespace App\Services;

use App\Models\ContactMessage;
use App\Models\ServiceRequest;
use App\Models\User;
use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FirestoreService
{
    protected Client $client;
    protected string $projectId;
    protected string $documentPath;

    public function __construct()
    {
        $this->projectId = env('FIREBASE_PROJECT_ID');
        $serviceAccountPath = storage_path('app/' . env('FIREBASE_CREDENTIALS_PATH'));

        if (!file_exists($serviceAccountPath)) {
            Log::error("Firebase credentials file not found at: {$serviceAccountPath}");
            return;
        }

        $this->client = new Client();
        $this->client->setAuthConfig($serviceAccountPath);
        $this->client->addScope('https://www.googleapis.com/auth/datastore');

        $this->documentPath = "projects/{$this->projectId}/databases/(default)/documents/requests/requests";
    }

    protected function getAccessToken(): ?string
    {
        try {
            $token = $this->client->fetchAccessTokenWithAssertion();
            return $token['access_token'] ?? null;
        } catch (Exception $e) {
            Log::error("Failed to fetch Firebase Access Token: " . $e->getMessage());
            return null;
        }
    }


    public function initializeCountsFromDatabase(): array
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['status' => 'error', 'message' => 'No access token'];

        try {
            $payload = [
                'fields' => [
                    'count' => ['integerValue' => User::where("approval_status", "pending")->count()],
                    'count_messages' => ['integerValue' => ContactMessage::where("checked","0")->count()],
                    'count_vip' => ['integerValue' => ServiceRequest::where("checked","0")->count()],
                    'last_updated' => ['timestampValue' => now()->toIso8601String()],
                ]
            ];

            $response = Http::withToken($accessToken)->patch("https://firestore.googleapis.com/v1/{$this->documentPath}", $payload);

            return $response->successful()
                ? ['status' => 'success', 'message' => 'Initialized counts successfully']
                : ['status' => 'error', 'message' => $response->body()];
        } catch (Exception $e) {
            Log::error("Firestore init error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function incrementField(string $field, int $amount = 1): array
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return ['status' => 'error', 'message' => 'No access token'];

        try {
            $current = Http::withToken($accessToken)->get("https://firestore.googleapis.com/v1/{$this->documentPath}");
            if (!$current->successful()) {
                return ['status' => 'error', 'message' => 'Failed to fetch current values'];
            }

            $data = $current->json();
            $currentValue = isset($data['fields'][$field]['integerValue'])
                ? (int)$data['fields'][$field]['integerValue']
                : 0;

            $newValue = $currentValue + $amount;

            $payload = [
                'fields' => [
                    $field => ['integerValue' => $newValue],
                    'last_updated' => ['timestampValue' => now()->toIso8601String()],
                ]
            ];

            $url = "https://firestore.googleapis.com/v1/{$this->documentPath}?updateMask.fieldPaths={$field}&updateMask.fieldPaths=last_updated";

            $response = Http::withToken($accessToken)->patch($url, $payload);

            return $response->successful()
                ? ['status' => 'success', 'message' => "{$field} updated to {$newValue}"]
                : ['status' => 'error', 'message' => $response->body()];
        } catch (Exception $e) {
            Log::error("Firestore increment error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
