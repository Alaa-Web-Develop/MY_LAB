<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\User;
use App\Models\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('type','admin')->get();
        return view('dashboard.users.index', compact('users'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|max:20|min:6',
            'type' => 'required|in:admin,lab,doctor',
        ]);
        $created=User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password')),
            'type' => $request->post('type'),
        ]);

      
        
        return redirect()->route('dashboard.users.index')->with('success', 'User added successfully..');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id",
            'password' => 'nullable|string|max:20|min:6',
            'type' => 'required|in:admin,lab,doctor',
        ]);
        $data = [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'type' => $request->post('type'),
        ];
        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->post('password')),
            ];
        }
        $user->update($data);
        return redirect()->route('dashboard.users.index')->with('success', 'User edited successfully..');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('dashboard.users.index')->with('success', 'User has been deleted!');
    }

}
