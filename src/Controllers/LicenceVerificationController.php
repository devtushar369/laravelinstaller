<?php


namespace Hashcode\laravelInstaller\Controllers;


use Hashcode\laravelInstaller\Services\EnvatoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LicenceVerificationController
{
    protected $envatoService;

    public function __construct(EnvatoService $envatoService)
    {
        $this->envatoService = $envatoService;
    }

    public function licenseVerification(Request $request)
    {
        $file = storage_path('app/permissionChecked');
        touch($file);
        return view('laravelInstaller::license_verification');
    }

    public function licenseVerificationStore(Request $request)
    {
        try {
            $request->validate([
                'access_code' => 'required|string',
                'envato_email' => 'required|string',
                'installed_domain' => 'required|string',
            ]);

            $purchaseCode = $request->input('access_code');
            $domain = $request->input('installed_domain');
            $buyerEmail = $request->input('envato_email');

            $data['purchase_code'] = $purchaseCode;
            $data['domain'] = $domain;
            $data['buyer_email'] = $buyerEmail;

            // Call the EnvatoService to register the license
            $response = $this->envatoService->registerLicense($data);

            // Handle the service response
            if ($response && isset($response['status']) && $response['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $response['message'] ?? 'License verified successfully.',
                ], 200);
            }
            // Handle error responses from the EnvatoService
            return response()->json([
                'status' => 'error',
                'message' => $response['message'] ?? 'Failed to verified your license. Please try again.',
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Handle unexpected errors
            Log::error('Error registering license: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error_details' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }
}
