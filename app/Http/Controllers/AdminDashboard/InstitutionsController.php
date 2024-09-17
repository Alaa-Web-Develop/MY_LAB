<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionsController extends Controller
{
    public function index()
    {
        $insts = Institution::all();
        return view('dashboard.institutions.index',compact('insts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.institutions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' =>['required','string','max:256'],
            
        ]);
        Institution::create($request->all());
        return redirect()->route('dashboard.institutions.index')->with('success','The Institution has been added!');

    }


    public function edit($id)
    {
        $inst = Institution::findOrFail($id);
        return view('dashboard.institutions.edit',compact('inst'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>['required','string','max:256'],
            
        ]);
        $inst=Institution::findorfail($id);
        $inst->update($request->all());
        return redirect()->route('dashboard.institutions.index')->with('success','The Institution has been Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inst=Institution::findorfail($id);
        $inst->delete();

        return redirect()->route('dashboard.institutions.index')->with('success','The Institution has Deleted!');

    }
}
