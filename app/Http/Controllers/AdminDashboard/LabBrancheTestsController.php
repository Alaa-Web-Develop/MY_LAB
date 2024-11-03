<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Lab;
use App\Models\Test;
use App\Models\Action;
use App\Models\LabOrder;
use App\Models\LabBranch;
use App\Models\SponserTest;
use Illuminate\Http\Request;
use App\Models\Lab_Branch_Test;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class LabBrancheTestsController extends Controller
{
    public function index()
    {
        //labOrders
        //join composite key two condition  on

        $tests_info = LabOrder::select([
            'tests.id as test_id',
            'tests.name as test_name',

            'labs.id as lab_id',
            'labs.name as lab_name',

            'lab_branches.name as branch',
            'lab_branches.id as branch_id',

            'lab_tests.price as test_price',
            'lab_tests.points as doctor_points',
            'lab_tests.discount_points as discount_points',
            'lab_tests.notes as notes',
            'lab_tests.created_at as created_at',

        ])->join('lab_tests', function ($join) {
            $join->on('lab_orders.test_id', '=', 'lab_tests.test_id')
                ->on('lab_orders.lab_id', '=', 'lab_tests.lab_id');
        })
            ->join('tests', 'lab_orders.test_id', '=', 'tests.id')
            ->join('labs', 'lab_orders.lab_id', '=', 'labs.id')
            ->join('lab_branches', 'lab_orders.lab_branche_id', '=', 'lab_branches.id')

            ->get();

        return view('dashboard.LabBranchTestInfo.index', compact('tests_info'));
    }
    public function getLabs()
    {
        $labs = Lab::get();
        return response()->json($labs);
    }

    public function getBranches($labId)
    {
        //$labId = $request->input('lab_id');
        $branches = LabBranch::where('lab_id', $labId)->get();
        return response()->json($branches);
    }

    public function store(Request $request)
    {
     //dd($request->all());
        $request->validate([
            'lab_id' => 'required|integer|exists:labs,id',

            'test_id' => [
                'required',
                'exists:tests,id',
                function ($attribute, $value, $fail) use ($request) {
                    if (DB::table('lab_tests')
                        ->where('test_id', $value)
                        ->where('lab_id', $request->lab_branche_id)
                        ->exists()
                    ) {
                        $fail('The combination of test and branch already exists.');
                    }
                },
            ],

            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/', //  'regex:/^\d+(\.\d{1,2})?$/', // Allows prices like 100.00 or 50
            'points' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'discount_points' => 'required|integer|min:0',
            'has_courier' => 'nullable|boolean',
        'courier_id' => 'nullable|integer|exists:couriers,id',
        'test_tot'=>'nullable|integer',
            'sponser_id'=>'nullable|integer|exists:sponsers,id',
        ]);

        $data=$request->except(['sponser_id']);

        try {
                   
        $createdLabBrnchTest = Lab_Branch_Test::create($data);
        $test_name = Test::where('id', $createdLabBrnchTest->test_id)->first();
        $lab_name = Lab::where('id', $createdLabBrnchTest->lab_id)->first();

        Action::create([
            'action' => "Admin assign test:$test_name for lab:$lab_name  ",
            'type' => 'lab_orders',
            'action_date' => now()
        ]);

          // Create SponserTest entry if sponser_id is provided
          if ($request->filled('sponser_id')) {
            $created_sponsered = SponserTest::create([
                'test_id' => $createdLabBrnchTest->test_id,
                'lab_id' => $createdLabBrnchTest->lab_id,
                'sponser_id' => $request->sponser_id,
                'quota' => $request->input('quota', 0), // Default to 0 if not provided
                'created_at' => now(),
            ]);
        }

    
      
        return redirect()->route('dashboard.labs.index')->with('success', 'test_info added..!');

        } catch (QueryException $e) {
            return redirect()->route('dashboard.labs.index')
            ->with('error', 'Duplicate test and lab combination not allowed. Please check your entries and try again.');
        }

    }

    public function updateTestBranche(Request $request, $test_id, $lab_id)
    {
        //dd($request->all());

        $request->validate([
            'lab_id' => 'required|integer|exists:labs,id',

            'test_id' => [
                'required',
                'exists:tests,id',
                function ($attribute, $value, $fail) use ($request) {
                    if (DB::table('lab_tests')
                        ->where('test_id', $value)
                        ->where('lab_id', $request->lab_id)
                        ->exists()
                    ) {
                        $fail('The combination of test and lab already exists.');
                    }
                },
            ],

            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/', //  'regex:/^\d+(\.\d{1,2})?$/', // Allows prices like 100.00 or 50
            'points' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'discount_points' => 'required|integer|min:0',

        ]);

        //dd($request->all()); //update composite key query builder To avoid errors

        $record = Lab_Branch_Test::where('test_id', $test_id)->where('lab_id', $lab_id)->first();
        if ($record) {
            DB::table('lab_tests')
                ->where('test_id', $test_id)
                ->where('lab_id', $lab_id)
                ->update([
                    'test_id' => $request->post('test_id'),
                    'lab_id' => $request->post('lab_id'),
                    'price' => $request->post('price'),
                    'points' => $request->post('points'),
                    'notes' => $request->post('notes'),
                    'discount_points' => $request->post('discount_points'),
                ]);
        }

        return redirect()->route('dashboard.labs.index')->with('success', 'test_info updated..!');
    }

    public function destroyTestBranche($test_id, $lab_id)
    {
        // Find the record by composite key
        $record = DB::table('lab_tests')
            ->where('test_id', $test_id)
            ->where('lab_id', $lab_id)
            ->first();
        if ($record) {
            // Delete the record
            DB::table('lab_tests')
                ->where('test_id', $test_id)
                ->where('lab_id', $lab_id)
                ->delete();
        }

        return redirect()->route('dashboard.lab_barnch_test.index')->with('success', 'test_info deleted_successfullys');
    }
}
