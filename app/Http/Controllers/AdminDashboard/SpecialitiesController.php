<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialitiesController extends Controller
{
    /**
     *  $table->id();
            // $table->string('name');
            // $table->enum('status',['active','inactive'])->default('active');
            // $table->timestamps();
     */
    public function index()
    {
        $specs = Speciality::all();
        return view('dashboard.specialities.index',compact('specs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.specialities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' =>['required','string','max:256'],
            'status'=>['required','in:active,inactive']
        ]);
        Speciality::create($request->all());
        return redirect()->route('dashboard.specialities.index')->with('success','The Speciality has been added!');

    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $spec = Speciality::findOrFail($id);
        return view('dashboard.specialities.edit',compact('spec'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>['required','string','max:256'],
            'status'=>['required','in:active,inactive']
        ]);
        $spec=Speciality::findorfail($id);
        $spec->update($request->all());
        return redirect()->route('dashboard.specialities.index')->with('success','The Speciality has been Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $spec=Speciality::findorfail($id);
        $spec->delete();

        return redirect()->route('dashboard.specialities.index')->with('success','The Speciality has Deleted!');

    }
}
