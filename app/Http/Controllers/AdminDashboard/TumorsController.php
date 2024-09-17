<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Tumor;
use Illuminate\Http\Request;

class TumorsController extends Controller
{
    public function index()
    {
        $tumors = Tumor::all();
        return view('dashboard.tumors.index',compact('tumors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.tumors.create');
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
        Tumor::create($request->all());
        return redirect()->route('dashboard.tumors.index')->with('success','The Tumor has been added!');

    }


    public function edit($id)
    {
        $tumor = Tumor::findOrFail($id);
        return view('dashboard.tumors.edit',compact('tumor'));
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
        $tumor=Tumor::findorfail($id);
        $tumor->update($request->all());
        return redirect()->route('dashboard.tumors.index')->with('success','The Tumor has been Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tumor=Tumor::findorfail($id);
        $tumor->delete();

        return redirect()->route('dashboard.tumors.index')->with('success','The Tumor has Deleted!');

    }
}
