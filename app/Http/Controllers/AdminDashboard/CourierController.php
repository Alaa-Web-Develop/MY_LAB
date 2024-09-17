<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\User;
use App\Models\Courier;
use App\Models\CourierArea;
use App\Models\Governorate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CourierLoginDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CourierController extends Controller
{
    public function index()
    {

   // Get couriers with their related areas
        $couriers = Courier::with('areas')->get();
        $govrs=Governorate::select('id','governorate_name_ar')->get();
        return view('dashboard.couriers.index', compact('couriers','govrs'));
    }

  
    public function store(Request $request)
    {

            // Validate the courier data
        $validated=$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email','unique:couriers,email'], // Ensure email is unique
            'areas' =>['required','array']
        ]);
        // Generate a random password
        $password = Str::random(8);

        // Create the courier
        $courier = Courier::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        // Step 2: Assign areas to the courier in courier_areas table
    foreach ($request->areas as $area) {
        CourierArea::create([
            'courier_id' => $courier->id,
            'area' => $area, // The Arabic name of the governorate
        ]);
    }

        // Create the user for login
        $user = User::create([
            'name' => $courier->name,
            'email' => $courier->email,
            'password' => Hash::make($password),  // Hash the password
            'type' => 'courier',  // Set the user type as 'carrier'
        ]);

        $courier->update(['user_id'=>$user->id]);
        // Send the email with login details
        Mail::to($courier->email)->send(new CourierLoginDetails($courier->name, $courier->email, $password));
        return redirect()->route('dashboard.couriers.index')->with('success', 'Courier has been created and login details have been sent!');
    }

    public function edit($id)
    {
        // Find the courier by ID or fail
        $courier = Courier::findOrFail($id);

        // Return the view with the courier data
        return view('couriers.edit', compact('courier'));
    }

    public function update(Request $request, $id)
{
    // Find the courier by ID or fail
    $courier = Courier::findOrFail($id);

    // Validate the request data
    // 'name' => 'required|string|max:255',
    // 'phone' => 'required|string|max:15',
    // 'email' => 'required|email|max:255|unique:couriers,email,' . $id,
    // 'areas' => 'required|array',
//unique:couriers,email,' . $id,
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:20'],
        'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,".$id,"unique:couriers,email,".$id] ,
        'areas' => 'required|array',
    ]);

    // Find the courier
    $courier = Courier::findOrFail($id);

    // Update courier details
    $courier->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
    ]);

    if($request->has('areas') && !empty($request->areas)){
        $courier->areas()->delete();
        foreach ($request->areas as $area) {
            $courier->areas()->create([
                'area' => $area,
            ]);
        }
    }

    // Update the associated user details (optional if couriers have a linked user account)
    $user = User::where('email', $courier->email)->first();
    if ($user) {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    }

    // Redirect back with a success message
    return redirect()->route('dashboard.couriers.index')->with('success', 'Courier has been updated successfully!');
}

public function destroy($id)
{
    // Find the courier by ID or fail
    //delete the associated user (if there's a user associated with the courier)
     // Delete the courier

    $courier=Courier::findOrFail($id);
    if($courier->user)
    {
        $courier->user->delete();
    }

    $courier->delete();

    // Redirect back with success message
    return redirect()->route('dashboard.couriers.index')->with('success', 'Courier has been deleted successfully!');
}

}
