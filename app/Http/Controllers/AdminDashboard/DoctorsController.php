<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\City;
use App\Models\User;
use App\Models\Action;
use App\Models\Doctor;
use App\Models\DoctorDoc;
use App\Models\Speciality;
use App\Models\Governorate;
use App\Models\Institution;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Notifications\NewDoctorProfile;
use Illuminate\Validation\Rules\Password;
use App\Notifications\DoctorStatusChanged;

use function PHPUnit\Framework\fileExists;
use App\Notifications\DoctorAddedFromMobile;
use Symfony\Contracts\Service\Attribute\Required;

class DoctorsController extends Controller
{
    public function index()
    {
        //Join

        $doctors = Doctor::join('cities', 'cities.id', '=', 'doctors.city_id')
            ->join('governorates', 'governorates.id', '=', 'doctors.governorate_id')
            ->join('specialities', 'specialities.id', '=', 'doctors.speciality_id')
            ->join('institutions', 'institutions.id', '=', 'doctors.institution_id')
            ->with('user')
            //->join('users', 'users.id', '=', 'doctors.user_id')

            ->select([
                'doctors.*',
                'cities.city_name_ar as city_name',
                'governorates.governorate_name_ar as govern_name',
                'specialities.name as spec_name',
                'institutions.name as inst_name',
                //'users.name as login_name'
            ])
            ->get();
        //dd($doctors);
        //$doctors = Doctor::with('doctorDocs')->get();
        return view('dashboard.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specs = Speciality::all();
        $insts = Institution::all();
        $govrs = Governorate::all();
        $cities = City::all();
        $users = User::all();

        return view('dashboard.doctors.create', compact('specs', 'insts', 'govrs', 'cities', 'users'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'speciality_id' => ['required', 'int', 'exists:specialities,id'],
            'institution_id' => ['required', 'int', 'exists:institutions,id'],
            'governorate_id' => ['required', 'int', 'exists:governorates,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'docs' => 'array',
            'doctor_notes' => ['string'],
            'Approval_Status' => ['in:pending,approved'],
            'phone' => ['required', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/','unique:doctors,phone'],
            'email' => ['required', 'email:rfc,dns','unique:doctors,email'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);
        //dd($request->all());

        $data = $request->except(['docs', 'password']);
        $data['random_number'] = $this->GenerateRandomNumber();

        DB::beginTransaction();
        try {
            //code if commit
            $created_doctor = Doctor::create($data);

            $imgsData = [];
            if ($files = $request->file('docs')) {
                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key . '-' . time() . '.' . $extension;
                    $path = "uploads/doctorDocs/";
                    $file->move($path, $filename);

                    //dd($path,$filename);

                    $imgsData[] = [
                        'doctor_id' => $created_doctor->id,
                        'docs' => $path . $filename,

                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ];
                    //dd($imgsData);  
                }
            }
            DoctorDoc::insert($imgsData);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return redirect()->route('dashboard.doctors.index')->with('success', 'Doctor profile has been added!');
    }



    public function edit($id)
    {
        //Join

        $specs = Speciality::all();
        $insts = Institution::all();
        $govrs = Governorate::all();
        $cities = City::all();
        // $users = User::all();

        $doctor = Doctor::with('doctorDocs')
            ->join('cities', 'cities.id', '=', 'doctors.city_id')
            ->join('governorates', 'governorates.id', '=', 'doctors.governorate_id')
            ->join('specialities', 'specialities.id', '=', 'doctors.speciality_id')
            ->join('institutions', 'institutions.id', '=', 'doctors.institution_id')
            ->select([
                'doctors.*',
                'cities.city_name_ar as city_name',
                'governorates.governorate_name_ar as govern_name',
                'specialities.name as spec_name',
                'institutions.name as inst_name'
            ])
            ->where('doctors.id', '=', $id)
            ->first();

        //dd($doctor);

        // $doctor = Doctor::with('doctorDocs')->findOrFail($id);

        //$doctor=Doctor::findorfail($id);

        // $doctor = Doctor::with('doctorDocs')->where('doctors.id','=',$id)->first();
        return view('dashboard.doctors.edit', compact('doctor', 'specs', 'insts', 'govrs', 'cities'));
    }


    public function update(Request $request, $id)
    {
        //dd($request->all());

        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'speciality_id' => ['required', 'int', 'exists:specialities,id'],
            'institution_id' => ['required', 'int', 'exists:institutions,id'],
            'governorate_id' => ['required', 'int', 'exists:governorates,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'docs' => 'array',
            'doctor_notes' => ['nullable', 'string'],
            'Approval_Status' => ['in:pending,approved'],
            'phone' => ['required', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/'],
            'email' => ['required', 'email:rfc,dns'],
            //'user_id' => ['nullable', 'int', 'exists:users,id'],

        ]);
        //dd($request->all());

        //================ beginTransaction
        DB::beginTransaction();
        try {
            //code...
            $doctor = Doctor::findOrFail($id);

            $oldStatus = $doctor->Approval_Status;
            $addedSource = $doctor->source;

            //dd($doctor);
            //===========old docs delete
            $doctor_docs = DoctorDoc::where('doctor_id', '=', $id)->get();
            if ($files = $request->file('docs')) {

                foreach ($doctor_docs as $obj) {
                    if (File::exists($obj->docs)) {
                        File::delete($obj->docs);
                    }

                    $obj->destroy($obj->id);
                }
            }
            //===========old docs delete

            $updated = $doctor->update([
                'name' => $request->post('name'),
                'speciality_id' => $request->post('speciality_id'),
                'institution_id' => $request->post('institution_id'),
                'governorate_id' => $request->post('governorate_id'),
                'city_id' => $request->post('city_id'),
                //'user_id' => $request->post('user_id'),
                'doctor_notes' => $request->post('doctor_notes'),
                'Approval_Status' => $request->post('Approval_Status'),
                'phone' => $request->post('phone'),
                'email' => $request->post('email'),
                'random_number' => $doctor->random_number
            ]);

            //update docto_docs
            //delete old images if exist
            $imgsData = [];
            if ($files = $request->file('docs')) {

                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key . '-' . time() . '.' . $extension;
                    $path = "uploads/doctorDocs/";
                    $file->move($path, $filename);

                    $imgsData[] = [
                        'doctor_id' => $id,
                        'docs' => $path . $filename,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            DoctorDoc::insert($imgsData);

            //if doctor status approved $notify:

            if ($oldStatus !== 'approved' && $doctor->Approval_Status === 'approved' &&  $addedSource === 'admin') {

                // Create the corresponding user record
                $user = User::create([
                    'name' => $doctor->name,
                    'email' => $doctor->email,
                    'password' => $doctor->random_number,
                    // 'password' => bcrypt($doctor->random_number), // Hash the password
                    'type' => 'doctor',
                ]);

                // Update the doctor record with the user ID
                $doctor->update(['user_id' => $user->id]);

                //Notification::route('mail', $doctor) //route('channel)
                $doctor->notify(new DoctorStatusChanged($doctor));
            }

            if ($oldStatus !== 'approved' && $doctor->Approval_Status === 'approved' &&  $addedSource === 'mobile') {

                // Create the corresponding user record
                $user = User::create([
                    'name' => $doctor->name,
                    'email' => $doctor->email,
                    //'password' => $doctor->random_number,
                    //'password' => bcrypt($doctor->random_number), // Hash the password
                    'password' => $doctor->random_number,
                    'type' => 'doctor',
                ]);

                // Update the doctor record with the user ID
                $doctor->update(['user_id' => $user->id]);

                //Notification::route('mail', $doctor) //route('channel)
                $doctor->notify(new NewDoctorProfile($doctor));
            }



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->route('dashboard.doctors.index')->with('success', 'Doctor profile has been Edit!');
    }


    public function destroy($id)
    {
        $doctor = Doctor::findorfail($id);

        $docsObj = DoctorDoc::where('doctor_id', '=', $id)->get();
        foreach ($docsObj as $obj) {
            if (File::exists($obj->docs)) {
                File::delete($obj->docs);
            }
            $obj->delete();
        }
        $doctor->delete();
        // $doctor = Doctor::findorfail($id);
        // $doctor->delete();

        return redirect()->route('dashboard.doctors.index')
            ->with('confirm-delete', 'Doctor profile has beenDeleted!');
    }

    // //Generate Random number
    public function GenerateRandomNumber()
    {
        do {
            $randomNumber = strtoupper(Str::random(10));
        } while (Doctor::where('random_number', $randomNumber)->exists());

        //do...while loop continues generating a new random number until it finds one that does not already exist in the Doctor table. This ensures that the generated randomNumber is unique for each Doctor record

        return $randomNumber;
    }

    //Ajax change status
    public function updateStatus(Request $request)
    {
        $doctor = Doctor::find($request->doctor_id);
        $oldStatus = $doctor->Approval_Status;
        $addedSource = $doctor->source;
//dd($doctor);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        // Update the approval status
        $doctor->Approval_Status = $request->Approval_Status;

        // Check if the status is being changed to approved
        //if doctor status approved $notify:

        if ($oldStatus !== 'approved' && $doctor->Approval_Status === 'approved' &&  $addedSource === 'admin') {

            // Create the corresponding user record
            $user = User::create([
                'name' => $doctor->name,
                'email' => $doctor->email,
                'password' => $doctor->random_number,
                // 'password' => bcrypt($doctor->random_number), // Hash the password
                'type' => 'doctor',
            ]);

            // Update the doctor record with the user ID
            $doctor->update(['user_id' => $user->id]);

            //Notification::route('mail', $doctor) //route('channel)
            $doctor->notify(new DoctorStatusChanged($doctor));

            Action::create([
                'action' => "Admin update $doctor->name status to approved",
                'type' => 'doctors',
                'action_date' => now()
            ]);
            
        }

        if ($oldStatus !== 'approved' && $doctor->Approval_Status === 'approved' &&  $addedSource === 'mobile') {

            // Create the corresponding user record
            $user = User::create([
                'name' => $doctor->name,
                'email' => $doctor->email,
                //'password' => $doctor->random_number,
                //'password' => bcrypt($doctor->random_number), // Hash the password
                'password' => $doctor->random_number,
                'type' => 'doctor',
            ]);

            // Update the doctor record with the user ID
            $doctor->update(['user_id' => $user->id]);

            //Notification::route('mail', $doctor) //route('channel)
            $doctor->notify(new NewDoctorProfile($doctor));
        }


        $doctor->save();

        return redirect()->route('dashboard.doctors.index')->with('success', 'Doctor Status has been Edit!');
    }
}
