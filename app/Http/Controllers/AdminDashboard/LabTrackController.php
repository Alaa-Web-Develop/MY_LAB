<?php

namespace App\Http\Controllers\AdminDashboard;

use Carbon\Carbon;
use App\Models\Action;
use App\Models\LabOrder;
use App\Models\TrackLabTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class LabTrackController extends Controller
{
    public function index()
    {
        // Fetch lab orders with related data labTrack
    $labOrders = LabOrder::with([
        'patient',
        'testQuestions',
        'labTest',
        'doctor',
        'test', // Assuming test has a 'name' attribute
        'labBranch', // Assuming labBranch has 'name', 'address', and 'phone' attributes
        'courierCollectedTest' => function ($query) {
            $query->with('courier'); // Eager load courier data
        },
        'labTrack' // Assuming labTrack has 'result_released_at', 'result', etc.
    ])
    ->orderBy('created_at', 'desc') // Show the most recent first
    ->get();

    return view('dashboard.labOrdersTracking.index', compact('labOrders'));
    }

    public function edit($id)
    {
        dd($id);
        $labOrder = LabOrder::findOrFail($id);

        return view('dashboard.labOrdersTracking.labOrderEdit', compact('labOrder'));
    }

    public function update(Request $request, $id)
    {
            // Validate the incoming request data
    $request->validate([
        'courier_collected_test_id'=>'nullable|int|exists:couriers,id',
        'expected_result_released_date' => 'nullable|date',
        'status' => 'required|in:ordered,collected_by_courier,lab_received_at',
        'lab_received_at' => 'nullable|date',
        'result_released_at' => 'nullable|date',

        'notes' => 'nullable|string',
        'results.*' => 'nullable|file|mimes:pdf,jpeg,png,doc,docx|max:20480', // Validate each file
    ]);
    
        $labOrder = LabOrder::findOrFail($id);

    // Check if labTrack exists
    if ($labOrder->labTrack) {
        // Update existing labTrack
        $labOrder->labTrack->update([
           'courier_collected_test_id'=> $request->courier_collected_test_id,
            'expected_result_released_date' => $request->expected_delivery_date,
            'status' => $request->status,
            'lab_received_at' => $request->delivered_at,
            'result_released_at' => $request->result_released_at,

            'notes' => $request->notes,
            'result' => $request->file('results') ? $this->storeResults($request->file('results')) : $labOrder->labTrack->result,
        ]);
    } else {
        // Create a new labTrack if it does not exist
        $labOrder->labTrack()->create([
            'courier_collected_test_id'=> $request->courier_collected_test_id,
            'lab_order_id'=>$id,
            'expected_result_released_date' => $request->expected_result_released_date,
            'status' => $request->status,
            'lab_received_at' => $request->lab_received_at,
            'result_released_at' => $request->result_released_at,

            'notes' => $request->notes,
            'created_at' => Carbon::now(),
            'result' => $request->file('results') ? $this->storeResults($request->file('results')) : null,
        ]);
    }

    Action::create([
        'action' => "lab update lab_order:$labOrder->id status  ",
        'type' => 'lab_orders',
        'action_date' => now()
    ]);
    
        return redirect()->route('dashboard.track-lab_orders.index')->with('success', 'Lab order updated successfully.');
    }

    protected function storeResults($files)
    {
        $results = [];
        foreach ($files as $file) {
            // Generate a unique filename with the original extension
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Move the file to the desired directory in public/uploads/lab_orders_test
            $file->move(public_path('uploads/labsResults'), $filename);
            
            // Store the path or filename in the results array
            $results[] = 'uploads/labsResults/' . $filename;
        }

        return json_encode($results);
    }


    public function downloadResult($id)
    {

        // Find the lab order
    $labOrder = LabOrder::findOrFail($id);
    // Decode the JSON-encoded file paths
    $results = json_decode($labOrder->labTrack->result, true);
    // Create a zip file with the results
    $zip = new \ZipArchive();
    $zipFilename = 'lab_order_' . $id . '_results.zip';
    //$zipPath = storage_path('app/public/' . $zipFilename);
    $zipPath = public_path('uploads/' . $zipFilename);

    if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
        foreach ($results as $file) {
            $filePath = public_path($file);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, basename($filePath));
            }
        }
        $zip->close();
    }
    // Return the zip file as a download
    return response()->download($zipPath)->deleteFileAfterSend(true);


    }
}


// JSON-Encoding:

// Encoding refers to converting data into a JSON string format. For example, you might convert an array of file paths into a JSON string and store it in the database.
// Example:
// php
// Copy code
// $results = ['uploads/labsResults/file1.jpg', 'uploads/labsResults/file2.pdf'];
// $jsonResults = json_encode($results); // Converts to JSON string
// JSON-Decoding:

// Decoding refers to converting a JSON string back into a PHP array or object that you can work with in your code.
// Example:
// php
// Copy code
// $jsonResults = '["uploads/labsResults/file1.jpg", "uploads/labsResults/file2.pdf"]';
// $results = json_decode($jsonResults, true); // Converts back to PHP array