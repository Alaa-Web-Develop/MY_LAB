<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Action;
use App\Models\Diagnose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiagnosesController extends Controller
{
    public function index()
    {
        $diags = Diagnose::all();
        return view('dashboard.diagnoses.index',compact('diags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.diagnoses.create');
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
        $created=Diagnose::create($request->all());

        Action::create([
            'action' => "Admin add Diagnose : $created->name ",
            'type' => 'doctors',
            'action_date' => now()
        ]);

        return redirect()->route('dashboard.diagnoses.index')->with('success','The Diagnose has been added!');

    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $diag = Diagnose::findOrFail($id);
        return view('dashboard.diagnoses.edit',compact('diag'));
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
        $diag=Diagnose::findorfail($id);
        $diag->update($request->all());
        return redirect()->route('dashboard.diagnoses.index')->with('success','The Diagnose has been Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $diag=Diagnose::findorfail($id);
        $diag->delete();

        return redirect()->route('dashboard.diagnoses.index')->with('success','The Diagnose has Deleted!');

    }
}
