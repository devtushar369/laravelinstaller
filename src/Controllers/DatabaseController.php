<?php


namespace Hashcode\laravelInstaller\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\BufferedOutput;
use PDO;

class DatabaseController extends Controller
{
    public function databaseSetup(Request $request)
    {
        $file = storage_path('app/licenseVerified');
        touch($file);
        return view('laravelInstaller::database_setup');
    }

    public function databaseSetupStore(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'database_host' => 'required',
                'database_port' => 'required|numeric',
                'database_name' => 'required',
                'database_username' => 'required',
            ]);

            $connection  = $this->checkDatabaseConnection($request);
            if (!$connection){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Database connection configuration mismatch. Please try again.',
                ], 500);
            }

            $data = [
                'DB_HOST' => $request->database_host,
                'DB_PORT' => $request->database_port,
                'DB_DATABASE' => $request->database_name,
                'DB_USERNAME' => $request->database_username,
                'DB_PASSWORD' => $request->database_password,
            ];

            $this->updateEnvVariables($data);

            // Clear and cache the configuration to apply changes
            Artisan::call('config:clear');
            Artisan::call('config:cache');

            $outputLog = new BufferedOutput();
            $this->migrate($outputLog);

            return response()->json([
                'status' => 'success',
                'message' => 'Database configuration updated successfully.'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the database configuration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    private function checkDatabaseConnection(Request $request)
    {
        $connection = 'mysql';

        $settings = config("database.connections.$connection");

        config([
            'database' => [
                'default' => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver' => $connection,
                        'host' => $request->input('database_host'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    protected function updateEnvVariables(array $data)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            foreach ($data as $key => $value) {
                $envKey = strtoupper(str_replace('database_', 'DB_', $key)); // Map to DB_ keys

                // Read the .env file content
                $env = file_get_contents($path);

                // Replace the key if it exists, or add it otherwise
                if (preg_match("/^{$envKey}=.*/m", $env)) {
                    $env = preg_replace("/^{$envKey}=.*/m", "{$envKey}={$value}", $env);
                } else {
                    $env .= "\n{$envKey}={$value}";
                }

                // Write the updated content back to the .env file
                file_put_contents($path, $env);
            }
        }
    }


    private function migrate(BufferedOutput $outputLog)
    {
        try {
            $db_host = env('DB_HOST', '127.0.0.1');
            $db_name = env('DB_DATABASE');
            $db_user = env('DB_USERNAME');
            $db_pass = env('DB_PASSWORD');
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $database = database_path('database.sql');
            $query = file_get_contents($database);
            $stmt = $conn->prepare($query);
            $stmt->execute();
        } catch (\Exception $e) {
            Log::error('error ='.$outputLog);
            return false;
        }
        return true;
    }


    private function response($message, $status, BufferedOutput $outputLog)
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }
}
