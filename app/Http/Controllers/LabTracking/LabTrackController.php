<?php

namespace App\Http\Controllers\LabTracking;

use App\Models\Lab;
use App\Models\LabOrder;
use App\Models\TrackLabTest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LabBranch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LabTrackController extends Controller
{
    public function index()
    {
//'name','lab_id','phone','hotline','email','Approval_Status','governorate_id','city_id','location','description','user_id'

        //display lab_order
        $user = Auth::user();        
        $branch_id=$user->labBranch->id;
        $branch=LabBranch::where('id',$branch_id)->first();

        // Fetch lab orders for the authenticated lab branch
       
        $labOrders = LabOrder::where('lab_branche_id', $branch_id)->with(['patient', 'test', 'labTrack', 'labTest', 'doctor'])
            ->orderBy('created_at', 'desc') //showing the most recent first
            ->get();

        return view('labTrack.index', compact('labOrders','branch'));
    }

    public function edit($id)
    {
       
        $labOrder = LabOrder::findOrFail($id);

        return view('labTrack.labOrderEdit', compact('labOrder'));
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
                'lab_order_id' => $id,
                'expected_delivery_date' => $request->expected_delivery_date,
                'status' => $request->status,
                'delivered_at' => $request->delivered_at,
                'notes' => $request->notes,
                'created_at' => Carbon::now(),
                'result' => $request->file('results') ? $this->storeResults($request->file('results')) : null,
            ]);
        }

        return redirect()->route('labTrack.index')->with('success', 'Lab order updated successfully.');
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
