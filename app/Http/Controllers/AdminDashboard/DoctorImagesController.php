<?php

namespace App\Http\Controllers\AdminDashboard;

use ZipArchive;
use App\Models\Doctor;
use App\Models\DoctorDoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class DoctorImagesController extends Controller
{
    public function show($doctor_id)
    {
        //dd($doctor_id);
        $doctor_docs = DoctorDoc::where('doctor_id', '=', $doctor_id)->get();
        $doctor = Doctor::where('id', '=', $doctor_id)->first();

        return view('dashboard.doctorDocs.show', compact('doctor_docs', 'doctor'));
    }

    public function destroy($id)
    {
        $DoctorDocs = DoctorDoc::where('doctor_id','=',$id)->get();
        
        foreach($DoctorDocs as $docObj)
        {
            if (File::exists($docObj->docs)) 
            {
                File::delete($docObj->docs);
            }
            $docObj->delete();
        }
       
        
        return redirect()->route('dashboard.doctors.index')->with('success', 'Doctor Document has beenDeleted!');
    }

    public function downloadDocs($id)
    {
        $DoctorDocs = DoctorDoc::where('doctor_id',$id)->get();

        $zip = new ZipArchive;
        $filename = "download-doctor-files.zip";

        if($zip->open(($filename),ZipArchive::CREATE | ZipArchive::OVERWRITE ) === TRUE)
        {


            foreach ($DoctorDocs as $Drdoc) {
                
                $nameInZibFile = basename($Drdoc->docs);
                $zip->addFile(public_path($Drdoc->docs),$nameInZibFile);
            }
            $zip->close();
       
        }
        //The file "F:\PHP track\0 Tasks\3 Medical\Medical\public\download-doctor-files.zip" does not exist
        if(File::exists(public_path($filename))){
            return response()->download(public_path($filename));
        }
       
        return response()->json([
            'message' => 'No uploaded files for doctor'
        ]);

    }
}
