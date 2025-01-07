<?php


namespace Hashcode\laravelInstaller\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminSetupController extends Controller
{

    public function adminSetup()
    {
        $file = storage_path('app/databaseSetuped');
        touch($file);

        return view('laravelInstaller::admin_setup');
    }

    public function adminSetupStore(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
                'demo_data' => 'required|boolean',
            ]);

            // Hash the password
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Check if a user exists in the 'users' table
            $user = DB::table('users')->first();

            $request->session()->forget('email');
            $request->session()->forget('password');

            session(['email' => $request->email]);
            session(['password' => $request->password]);

            if ($user) {
                // Update the user's email and password
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'email' => $validatedData['email'],
                        'password' => $validatedData['password'],
                    ]);
            } else {
                // Insert a new user record
                DB::table('users')->insert([
                    'name' => 'admin',
                    'email' => $validatedData['email'],
                    'password' => $validatedData['password'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($validatedData['demo_data']) {
                Artisan::call('db:seed', ['--force' => true]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Admin user updated or created successfully.',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating or creating the admin user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
