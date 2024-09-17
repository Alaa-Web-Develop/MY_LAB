<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Lab;
use App\Models\City;
use App\Models\User;
use App\Models\Action;
use App\Models\Governorate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LabsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labs = Lab::with(['branches','tests'])->join('cities', 'cities.id', '=', 'labs.city_id')
            ->join('governorates', 'governorates.id', '=', 'labs.governorate_id')
            ->select([
                'labs.*',
                'cities.city_name_ar as city_name',
                'governorates.governorate_name_ar as govern_name',
              
                
            ])
            ->latest()
            ->get();

        
        return view('dashboard.labs.index', compact('labs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $govrs = Governorate::all();
        $cities = City::all();
       

        return view('dashboard.labs.create', compact('govrs', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'governorate_id' => ['required', 'int', 'exists:governorates,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            // 'logo'=>'nullable|image|mimes:png,jpg,jpeg,webp',
            'location' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],

            'hotline' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'Approval_Status' => ['in:pending,approved'],
            'phone' => ['required', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/'],
            'email' => ['nullable', 'email:rfc,dns'],
           

        ]);


        $data = $request->except(['logo']);

        //upload logo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo_ext = $file->getClientOriginalExtension();
            $logo_name = time() . '.' . $logo_ext;
            $logo_path = "uploads/labsLogo/";

            $logofile = $file->move($logo_path, $logo_name);
            $uploadedPhoto = $logofile->getPathname();

            $data['logo'] = $uploadedPhoto;
        }

  
        //add lab
        $createdLab = Lab::create($data);

            


        Action::create([
            'action' => "Admin add anew lab:  $createdLab->name  ",
            'type' => 'lab_orders',
            'action_date' => now()
        ]);
        
        return redirect()->route('dashboard.labs.index')->with('success', 'Lab profile has been added!');
       
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $lab=Lab::findOrFail($id);
        $govrs = Governorate::all();
        $cities = City::all();
    
       

        return view('dashboard.labs.edit',compact('lab','govrs','cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $lab=Lab::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'governorate_id' => ['required', 'int', 'exists:governorates,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            // 'logo'=>'nullable|image|mimes:png,jpg,jpeg,webp',
            'location' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],

            'hotline' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'Approval_Status' => ['in:pending,approved'],
            'phone' => ['required', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/'],
            'email' => ['nullable', 'email:rfc,dns'],
           

        ]);


        $data = $request->except(['logo']);

        //upload logo
        if ($request->hasFile('logo')) 
        {
            //delete old first
            if(File::exists($lab->logo) )
            {
                File::Delete($lab->logo);
            }
            $file = $request->file('logo');
            $logo_ext = $file->getClientOriginalExtension();
            $logo_name = time() . '.' . $logo_ext;
            $logo_path = "uploads/labsLogo/";

            $logofile = $file->move($logo_path, $logo_name);
            $uploadedPhoto = $logofile->getPathname();

            $data['logo'] = $uploadedPhoto;
        }

  

        //edit lab
        $lab->update($data);
        return redirect()->route('dashboard.labs.index')->with('success', 'Lab profile has been editted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lab=Lab::findOrFail($id);
        if(File::exists($lab->logo) )
        {
            File::Delete($lab->logo);
        }
        $lab->delete();
        return redirect()->route('dashboard.labs.index')->with('success', 'Lab profile has been deleted!');

        
    }


    //Ajax for display in table
    public function getTests(Lab $lab)
    {
        // $lab=Lab::where('id',$lab)->first();
        // dd($lab);
        $lab_name=$lab->name;
        // Eager load the tests with additional pivot data from the lab_tests table
        $tests = $lab->tests()->get()->map(function ($test) {
            return [
                
                'name' => $test->name,
                'price' => $test->pivot->price,
                'points' => $test->pivot->points,
                'discount_points' => $test->pivot->discount_points,
                'notes' => $test->pivot->notes,
                
            ];
        });

        return view('dashboard.labs.showLabTest',compact('tests','lab_name'));
    }


    
}
