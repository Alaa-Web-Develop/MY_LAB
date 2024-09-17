<?php

namespace App\Http\Controllers\Apis;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Rules\DifferentFromOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    //update password
    public function passwordChange(Request $request)
    {
        // Get the authenticated user
    $user = Auth::guard('sanctum')->user();

    // Check if the user is authenticated
    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Login details are incorrect.'
        ], 200);
    }

    // Validate the request
    $request->validate([
        'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
            if (!Hash::check($value, $user->password)) {
                $fail('Login details is incorrect.');
            }
        }],
        'new_password' => ['required', 'string', 'min:8'],
    ]);

    // If validation passes, update the password
    $user->password = Hash::make($request->post('new_password'));
    $user->save();

    // Log the action
    $doctor_name = $user->doctor->name;
    Action::create([
        'action' => "Doctor: $doctor_name changed their login password",
        'type' => 'doctors',
        'action_date' => now()
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Password changed successfully.'
    ]);



        // $request->validate([
        //     'current_password' => ['required', function ($attribute, $value, $fail) {
        //         if (!Hash::check($value, Auth::user()->password)) {
        //             $fail('The current password is incorrect.');
        //         }
        //     }],
        //     'new_password' => ['required', 'string', 'min:8'],
        // ]);
        // $user = Auth::guard('sanctum')->user();
        // //dd($user);
        // if ($user) {
        //     $user->password = Hash::make($request->post('new_password'));
        //     $user->save();
        //     //dd($user);

        //     //Add Action
        //     $doctor_name = $user->doctor->name;
        //     Action::create([
        //         'action' => "Doctor: $doctor_name change his login password",
        //         'type' => 'doctors',
        //         'action_date' => now()
        //     ]);
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Password changed successfully.'
        //     ]);
        // }

        // return response()->json([
        //     'status' => 'error',
        //     'message' => 'Login details is incorrect'
        // ], 200);
    }
}
