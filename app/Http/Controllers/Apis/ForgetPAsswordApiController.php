<?php

namespace App\Http\Controllers\Apis;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ForgetPAsswordApiController extends Controller
{
    //
    public function forgotPassword(Request $request)
    {
        //validate email
        $request->validate([
            'email' => ['required', 'email', 'exists:doctors,email'],
        ]);

        //find doctor to send random number , save random_number,send it via email

        $doctor = Doctor::where('email', $request->email)->firstOrFail();
        $randomNumber = Str::random(8);

    //updateOrCreate method expects two arguments: the first is an array of conditions for finding the record, and the second is an array of values for updating or creating the record

        $user = User::updateOrCreate(
            ['email' => $doctor->email], // Condition to find the user
            [
                'name' => $doctor->name, // Update or set the user's name
                'password' => Hash::make($randomNumber) // Hash and set the random password
            ]
        );


        $doctor->random_number = $randomNumber;
        $doctor->user_id = $user->id;
        $doctor->save();

        Mail::send('emails.forget_password', ['randomNumber' => $randomNumber], function ($message) use ($doctor) {
            $message->to($doctor->email)->subject('Your Password Reset Code');
        });
        return response()->json([
            'message' => 'Reset Code has been sent to your email.',
            'random_number'=>$randomNumber,
        ], 200);
        //send($view, $data = [], $callback = null)

    }



    //Login with Random Number and Enforce Password Change
    public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'email' => ['required', 'email'],
            'random_number' => ['required'],
        ]);
        // Attempt to find doctor by email and random number
        $doctor = Doctor::where('email', $request->email)
            ->where('random_number', $request->random_number)
            ->first();

        if (!$doctor) {
            return response()->json(['message' => 'Invalid credentials or reset code.'], 401);
        }

        // Authenticate the user
        $user = $doctor->user;
        Auth::login($user);

        // Generate an API token (assuming you are using Laravel Sanctum)
        $token = $user->createToken('doctor-token')->plainTextToken;

        // Return the token and enforce password change
        return response()->json([
            'message' => 'Please change your password.',
            'force_password_change' => true,
            'token' => $token,
        ], 200);
    }

    //Enforce Password Change Method
    public function changePasswordForForget(Request $request)
    {
        $request->validate([
            'random_number' => ['required', 'string'], // The reset code
            'password' => ['required', 'string', 'confirmed', Password::min(6)->mixedCase()->letters()->numbers()],
        ]);
        
       // Find the user by the random number provided in the request
    $doctor = Doctor::where('random_number', $request->random_number)->first();
    
    if ($doctor) {
        // Get the associated user
        $user = $doctor->user;

        // Update the user's password with the new one
        $user->password = Hash::make($request->password);
        $user->save();

        // Optionally, reset the random number to null or regenerate it to avoid reuse
        $doctor->random_number = null;
        $doctor->save();

        // Return a success message
        return response()->json([
            'message' => 'Password changed successfully.',
        ]);
    } else {
        // If no doctor is found with the provided random number, return an error response
        return response()->json([
            'error' => 'Invalid reset code.',
        ], 400);
    }
    
    }
}
