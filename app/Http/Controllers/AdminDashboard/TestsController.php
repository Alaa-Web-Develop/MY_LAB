<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Test;
use App\Models\Tumor;
use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Diagnose;
use App\Models\TestQuestion;

class TestsController extends Controller
{
    public function index()
    {
        $tests = Test::with('questions')->leftJoin('diagnoses', 'diagnoses.id', '=', 'tests.diagnose_id')
            ->select([
                'tests.*',
                'diagnoses.name as diag_name'
            ])
            ->get();

        $diagnoses = Diagnose::all();

        $couriers=Courier::get();

        return view('dashboard.tests.index', compact('tests', 'diagnoses','couriers'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'diagnose_id' => ['integer', 'exists:diagnoses,id'],
            'details' => ['required', 'string'],
           // 'points' => 'required|numeric',
            'status' => ['in:valid,invalid'],
        
             // Conditional validation for questions
        'questions' => ['nullable', 'array'],
        'questions.*.text' => ['nullable', 'string', 'required_if:questions.*.options,!=,null'],
        'questions.*.options' => ['nullable', 'array'],
        'questions.*.options.*' => ['nullable', 'string'],

       ]);

        //dd($request->post('points'));

        $created = Test::create([
            'name' =>  $validated['name'],
            'diagnose_id' => $validated['diagnose_id'],
            'details' => $validated['details'],
           // 'points' => $request->post('points'),
            'status' => $validated['status'],
        
            // 'has_courier'=>$validated['has_courier'],
            // 'courier_id'=>$validated['courier_id'],
            // Store questions as JSON
'questions'=>isset($validated['questions']) ? json_encode($validated['questions']) : null,
        ]);
        //dd($created);

    // Handle questions if they are provided
    if (isset($validated['questions']) && !empty($validated['questions'])) {
        foreach ($validated['questions'] as $questionData) {
            // Ensure 'text' field is not null
            if (!isset($questionData['text']) || trim($questionData['text']) === '') {
                continue; // Skip this question if 'text' is missing
            }

            TestQuestion::create([
                'test_id' => $created->id,
                'question' => $questionData['text'],
                'options' => isset($questionData['options']) ? json_encode($questionData['options']) : null,
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
            'diagnose_id' => ['integer', 'exists:diagnoses,id'],
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
