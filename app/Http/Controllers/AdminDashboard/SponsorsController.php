<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Sponser;
use Illuminate\Http\Request;

class SponsorsController extends Controller
{
    public function index()
    {

        $sponsors = Sponser::get();
        return view('dashboard.sponsors.index', compact('sponsors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        if ($request->hasFile('logo')) {
           $file=$request->file('logo');
           $extension=$file->getClientOriginalExtension();
           $filename=time().'.'.$extension;
           $path='uploads/sponsors/';
           $moved=$file->move($path,$filename); //Moves the file to a new location.
        }

        // Create a new sponsor
        $sponsor = new Sponser();
        $sponsor->name = $request->input('name');
        $sponsor->logo = $moved;
        $sponsor->save();

        return redirect()->route('dashboard.sponsors.index')->with('success','new sponsor has been added..!');
    }

    public function update(Request $request, $id)
{
    // Validate the request
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
    ]);

    // Find the sponsor by ID
    $sponsor = Sponser::findOrFail($id);

    // Handle file upload
    if ($request->hasFile('logo')) {
        // Delete old logo if exists
        if ($sponsor->logo && file_exists(public_path($sponsor->logo))) {
            unlink(public_path($sponsor->logo));
        }

        // Upload new logo
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $path = 'uploads/sponsors/';
        $file->move($path, $filename);
        
        // Store the new logo path
        $logoPath = $path . $filename;
    } else {
        // Retain the old logo path if no new file is uploaded
        $logoPath = $sponsor->logo;
    }

    // Update the sponsor
    $sponsor->name = $request->input('name');
    $sponsor->logo = $logoPath; // Update the logo path
    $sponsor->save();

    return redirect()->route('dashboard.sponsors.index')->with('success', 'Sponsor details updated successfully!');
}


public function destroy($id)
{
    // Find the sponsor by ID
    $sponsor = Sponser::findOrFail($id);

    // Check if there is a logo and delete it
    if ($sponsor->logo && file_exists(public_path($sponsor->logo))) {
        unlink(public_path($sponsor->logo));
    }

    // Delete the sponsor record
    $sponsor->delete();

    // Redirect with a success message
    return redirect()->route('dashboard.sponsors.index')->with('success', 'Sponsor deleted successfully!');
}


}
