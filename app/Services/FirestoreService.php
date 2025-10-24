<?php

namespace App\Services;

use App\Models\User;
use Google\Client;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class FirestoreService
{
    protected Client $client;
    protected string $projectId;

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
    }

    protected function getAccessToken(): ?string
    {
        if (!isset($this->client)) {
            return null;
        }

        try {
            $token = $this->client->fetchAccessTokenWithAssertion();
            return $token['access_token'] ?? null;
        } catch (Exception $e) {
            Log::error("Failed to fetch Firebase Access Token: " . $e->getMessage());
            return null;
        }
    }


    public function updateRequestsCountInFirestore(): array
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return ['status' => 'error', 'message' => 'Failed to get access token.'];
        }

        try {
            $documentPath = "projects/{$this->projectId}/databases/(default)/documents/requests/requests";

            $newCount = User::where("approval_status","pending")->count();


            $payload = [
                'fields' => [
                    'count' => [
                        'integerValue' => (string) $newCount,
                    ],
                    'last_updated' => [
                        'timestampValue' => now()->toIso8601String(),
                    ]
                ]
            ];


            $url = "https://firestore.googleapis.com/v1/{$documentPath}?updateMask.fieldPaths=count&updateMask.fieldPaths=last_updated";

            $response = Http::withToken($accessToken)
                ->patch($url, $payload);

            if ($response->successful()) {
                return ['status' => 'success', 'data' => $response->json()];
            } else {
                Log::error("Firestore Update Failed ({$response->status()}): " . $response->body());
                return ['status' => 'error', 'message' => 'Firestore update failed.', 'details' => $response->json()];
            }

        } catch (Exception $e) {
            Log::error("Exception during Firestore Update: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
