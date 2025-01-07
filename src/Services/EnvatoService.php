<?php


namespace Hashcode\laravelInstaller\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnvatoService
{

    public function verifyPurchaseCode($purchaseCode)
    {
        $url = "https://envato-client.ayaantec.com/api/verify-puchase-code?code={$purchaseCode}";

        $response = Http::get($url);

        if ($response->successful()) {
            return [
                'valid' => true,
                'data' => $response->json(),
            ];
        }

        $errorMessage = $response->json('error') ?? 'Invalid purchase code';

        if (str_contains($errorMessage, 'blocked')) {
            $errorMessage = 'The provided purchase code is invalid';
        }

        return [
            'valid' => false,
            'message' => $errorMessage,
        ];
    }

    public function registerLicense($payload)
    {
        try {
//            $url = "http://envato-client.test/api/register-license";
            $url = "https://envato-client.ayaantec.com/api/register-license";

            // Send POST request to the API
            $response = Http::post($url, $payload);

            // Check if the response is successful
            if ($response->successful()) {
                return $response->json(); // Return the successful response
            }

            // Handle non-successful HTTP responses
            $responseData = $response->json();

            return [
                'status' => 'error',
                'message' => $responseData['message'] ?? 'An error occurred.',
                'http_status' => $response->status(),
            ];
        } catch (\Exception $e) {
            // Handle exceptions (e.g., network issues)
            Log::error('Error in registerLicense: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error_details' => $e->getMessage(),
            ];
        }
    }
}
