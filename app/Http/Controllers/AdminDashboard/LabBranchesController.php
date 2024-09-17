<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Lab;
use App\Models\City;
use App\Models\User;
use App\Models\Action;
use App\Models\LabBranch;
use App\Models\Governorate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\LabBranchLoginDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class LabBranchesController extends Controller
{
     
    public function index()
    {
        $labBranches = LabBranch::join('cities', 'cities.id', '=', 'lab_branches.city_id')
        ->join('governorates', 'governorates.id', '=', 'lab_branches.governorate_id')
        ->join('labs','labs.id','=','lab_branches.lab_id')
        ->with('user')
        //->join('users', 'users.id', '=', 'lab_branches.user_id')
        ->select([
            'lab_branches.*',
            'cities.city_name_ar as city_name',
            'governorates.governorate_name_ar as govern_name',
            'labs.name as lab_name',
            //'users.name as login'
        ])
        ->latest()
        ->get();

    return view('dashboard.labBranches.index', compact('labBranches'));
    }


    public function create()
    {
        $govrs = Governorate::all();
        $cities = City::all();
        $labs=Lab::all();
        $users=User::all();

        return view('dashboard.labBranches.create', compact('govrs', 'cities','labs','users'));
    }


    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'governorate_id' => ['required', 'int', 'exists:governorates,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'lab_id'=>['required', 'int', 'exists:labs,id'],
          
            'location' => ['nullable', 'string'],
            'hotline' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'Approval_Status' => ['in:pending,approved'],
            'phone' => ['required', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/','unique:lab_branches,phone'],
            'email' => ['nullable', 'email:rfc,dns','unique:lab_branches,email'],
            'user_id' =>['nullable', 'int', 'exists:users,id'],
        ]);

        $data = $request->except(['random_number']);
        $data['random_number'] = $this->GenerateRandomNumber();

        //add barnch
       $created=LabBranch::create($data);

       Action::create([
        'action' => "Admin create anew lab_branch: $created->name ",
        'type' => 'lab_orders',
        'action_date' => now()
    ]);

    // Create the corresponding user record
    if ($created->Approval_Status == 'approved') {
        $password = $created->random_number;
        $user = User::create([
            'name' => $created->name,
            'email' => $created->email,
            'password' => bcrypt($password), // Hash the password
            'type' => 'lab',
        ]);

    // Update the doctor record with the user ID
    $created->update(['user_id' => $user->id]);

// Send email with login details
Mail::to($created->email)->send(new LabBranchLoginDetails($created, $password));
 }
        return redirect()->route('dashboard.labs.index')->with('success', 'Lab_Branch profile has been added!');
       
   
}

   
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $LabBranch=LabBranch::findOrFail($id);

        $govrs = Governorate::all();
        $cities = City::all();
        $labs=Lab::all();
        $users=User::all();

        return view('dashboard.labBranches.edit',compact('LabBranch','govrs','cities','labs','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $LabBranch=LabBranch::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'governorate_id' => ['required', 'int', 'exists:governorates,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'lab_id'=>['required', 'int', 'exists:labs,id'],
            'location' => ['nullable', 'string'],
            'hotline' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'Approval_Status' => ['in:pending,approved'],
            'phone' => ['required', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/','unique:lab_branches,phone'],
            'email' => ['nullable', 'email:rfc,dns','unique:lab_branches,email'],
            'user_id' =>['nullable', 'int', 'exists:users,id'],
        ]);

  
        //edit lab
      // $updated=$LabBranch->update($request->all()); this return t\f; 
$LabBranch->update($request->all());
$updated = $LabBranch; // $LabBranch now contains the updated object


    // Check if the Approval_Status was changed to approved
    if ($updated->Approval_Status == 'approved' && !$updated->user_id) {
        // Create user if it does not exist
        $password = $updated->random_number ?: $this->GenerateRandomNumber();
        $user = User::create([
            'name' => $updated->name,
            'email' => $updated->email,
            'password' => bcrypt($password), // Hash the password
            'type' => 'lab',
        ]);

        // Update lab branch with user_id and random_number if missing
        $updated->update([
            'user_id' => $user->id,
            'random_number' => $updated->random_number ?: $password,
        ]);

        // Send email with login details
        Mail::to($updated->email)->send(new LabBranchLoginDetails($updated, $password));
}

        return redirect()->route('dashboard.lab_branches.index')->with('success', 'Lab_Branch profile has been editted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $LabBranch=LabBranch::findOrFail($id);
     
        $LabBranch->delete();
        return redirect()->route('dashboard.lab_branches.index')->with('success', 'Lab_Branch profile has been deleted!');

        
    }



    // updateStatus om Modal show branches=============

    public function updateStatus(Request $request, $id)
{
    $LabBranch = LabBranch::findOrFail($id);

    $request->validate([
        'Approval_Status' => ['in:pending,approved'],
    ]);

    // Update the lab branch status
    $LabBranch->update($request->all());

    // Check if the Approval_Status was changed to approved
    if ($LabBranch->Approval_Status === 'approved' && !$LabBranch->user_id) {
        // Create user if it does not exist
        $password = $LabBranch->random_number ?: $this->GenerateRandomNumber();
        $user = User::create([
            'name' => $LabBranch->name,
            'email' => $LabBranch->email,
            'password' => bcrypt($password), // Hash the password
            'type' => 'lab',
        ]);

        // Update lab branch with user_id and random_number if missing
        $LabBranch->update([
            'user_id' => $user->id,
            'random_number' => $LabBranch->random_number ?: $password,
        ]);

        // Send email with login details
        Mail::to($LabBranch->email)->send(new LabBranchLoginDetails($LabBranch, $password));
    }

    return redirect()->route('dashboard.labs.index')->with('success', 'update status done successfully');;
}


    public function GenerateRandomNumber()
    {
        do {
            $randomNumber = strtoupper(Str::random(10));
        } while (LabBranch::where('random_number', $randomNumber)->exists());

        //do...while loop continues generating a new random number until it finds one that does not already exist in the Doctor table. This ensures that the generated randomNumber is unique for each Doctor record

        return $randomNumber;
    }
}
