<?php

namespace App\Http\Controllers\Apis;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
      // Validate the request
    $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:6',
        'device_name' => 'string|max:255'
    ]);

    // Attempt to find the doctor by random_number
    $doctor = Doctor::where('random_number', $request->password)->first();

    // Check if the doctor exists
    if (!$doctor) {
        return response()->json([
            'message' => 'Login details is invalid.',
        ], 422);
    }

    // Retrieve the approval status
    $approve = $doctor->Approval_Status;

    // Attempt to find the user by email
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // Check if the doctor profile is approved
        if ($doctor->Approval_Status == 'approved') {
            // Generate the token for the user
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name);

// Determine if it's the first login based on the source
        $isFirstLogin = ($doctor->source == 'admin') ? $user->isFirstLogin() : false;

        if ($isFirstLogin) {
            $user->first_login = now();
            $user->save();
        }
        
            // Check for first login
            // $isFirstLogin = $user->isFirstLogin();
            // if ($isFirstLogin) {
            //     $user->first_login = now();
            //     $user->save();
            // }

            // Return success response
            return response()->json([
                'message' => 'Login successful.',
                'token' => $token->plainTextToken,
                'user' => $user,
                'isFirstLogin' => $isFirstLogin,
                'Approval_Message' => 'Profile approved.'
            ], 200);
        } else {
            // Return a message indicating that the doctor is still pending approval
            return response()->json([
                'message' => 'Your account is pending approval. Please wait for admin approval.',
                'Approval_Message' => 'pending'
            ], 403); // Return 403 Forbidden
        }
    } else {
        // If the user credentials are incorrect
        return response()->json([
            'message' => 'Login details is invalid or your profile has not been approved yet.',
        ], 422);
    }
}



    //logout >> delete token
    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();


        if (null === $token) {
            $user->currentAccessToken()->delete();
            return Response::json([
                'message' => 'current user token has been deleted'
            ]);
        }
        $personalAccessToken = PersonalAccessToken::findToken($token);
        if ($user->id == $personalAccessToken->tokenable_id && get_class($user) == $personalAccessToken->tokenable_type) {
            $personalAccessToken->delete();
            return Response::json([
                'message' => 'user token you sent has been deleted',

            ]);
        }
    }
    // public function revokeAllTokens()
    // {
    //     $user = Auth::guard('sanctum')->user();
    //     $user->tokens()->delete();
    // }

    //check the first Login
    public function checkFirstLogin()
    {
        //auth user
        $request = App::make(Request::class);
        $user = $request->user();
        $isFirstLogin = $user->isFirstLogin(); //return
        if ($isFirstLogin) {
            $user->first_login = now();
            $user->save();
        }
        return $isFirstLogin;
    }
}
