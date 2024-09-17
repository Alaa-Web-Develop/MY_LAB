<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Test;
use App\Models\Tumor;
use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\TestQuestion;

class TestsController extends Controller
{
    public function index()
    {
        $tests = Test::with('questions')->leftJoin('tumors', 'tumors.id', '=', 'tests.tumor_id')
            ->select([
                'tests.*',
                'tumors.name as tumor_name'
            ])
            ->get();

        $tumors = Tumor::all();

        $couriers=Courier::get();

        return view('dashboard.tests.index', compact('tests', 'tumors','couriers'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'tumor_id' => ['integer', 'exists:tumors,id'],
            'details' => ['required', 'string'],
           // 'points' => 'required|numeric',
            'status' => ['in:valid,invalid'],
        
            // 'has_courier'=>['boolean'],
            // 'courier_id'=>['nullable','exists:couriers,id'],
            'questions'=>['nullable','array'],
            'questions.*.text'=>['required_with:questions','string'],
            'questions.*.options'=>['required_with:questions','array'],
            'questions.*.options.*'=>['required_with:questions','string'],
        ]);

        //dd($request->post('points'));

        $created = Test::create([
            'name' =>  $validated['name'],
            'tumor_id' => $validated['tumor_id'],
            'details' => $validated['details'],
           // 'points' => $request->post('points'),
            'status' => $validated['status'],
        
            // 'has_courier'=>$validated['has_courier'],
            // 'courier_id'=>$validated['courier_id'],
            // Store questions as JSON
'questions'=>isset($validated['questions']) ? json_encode($validated['questions']) : null,
        ]);
        //dd($created);

        // If there are any questions, loop through and add them
if($request->filled('questions')){
foreach($validated['questions'] as $questionData){
    TestQuestion::create([
'test_id' =>  $created->id,
'question'=>$questionData['text'],//question
// Convert options to JSON
'options'=>json_encode($questionData['options']),
    ]);
}
} 
//filled : Determine if the request contains a non-empty value for an input item.






        Action::create([
            'action' => "Admin add anew test: $created->name   ",
            'type' => 'lab_orders',
            'action_date' => now()
        ]);

        return redirect()->route('dashboard.tests.index')->with('success', 'Test has been added!');
    }

    public function update(Request $request, $id)
    {

        $test = Test::findOrFail($id);

        //dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'tumor_id' => ['integer', 'exists:tumors,id'],
            'details' => ['required', 'string'],
           // 'points' => 'required|numeric',
            'status' => ['in:valid,invalid'],
          


        ]);
        $test->update($request->all());
        return redirect()->route('dashboard.tests.index')->with('success', 'Test has been updated!');
    }

    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();
        return redirect()->route('dashboard.tests.index')->with('success', 'Test has been deleted!');
    }
}
