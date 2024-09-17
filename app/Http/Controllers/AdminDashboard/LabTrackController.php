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
        
        //display lab_order
        ///$labBranchId = auth('lab_branch')->id();

        // Fetch lab orders for the authenticated lab branch
        // $labOrders = LabOrder::where('branch_id', $labBranchId) with(['labTrack', 'labTest', 'patient', 'test'])
        $labOrders = LabOrder::with(['patient', 'test','labTrack','labTest','doctor'])
        ->orderBy('created_at', 'desc') //showing the most recent first
        ->get();
        //dd( $labOrders);
            

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
        'expected_delivery_date' => 'required|date',
        'status' => 'required|in:pending,delivered',
        'delivered_at' => 'nullable|date',
        'notes' => 'nullable|string',
        'results.*' => 'nullable|file|mimes:pdf,jpeg,png,doc,docx|max:20480', // Validate each file
    ]);
    
        $labOrder = LabOrder::findOrFail($id);

    // Check if labTrack exists
    if ($labOrder->labTrack) {
        // Update existing labTrack
        $labOrder->labTrack->update([
           
            'expected_delivery_date' => $request->expected_delivery_date,
            'status' => $request->status,
            'delivered_at' => $request->delivered_at,
            'notes' => $request->notes,
            'result' => $request->file('results') ? $this->storeResults($request->file('results')) : $labOrder->labTrack->result,
        ]);
    } else {
        // Create a new labTrack if it does not exist
        $labOrder->labTrack()->create([
            'lab_order_id'=>$id,
            'expected_delivery_date' => $request->expected_delivery_date,
            'status' => $request->status,
            'delivered_at' => $request->delivered_at,
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