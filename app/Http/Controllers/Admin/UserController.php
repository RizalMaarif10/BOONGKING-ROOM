<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }


    public function create()
    {

        return view('admin.users.create');
    }


    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'

        ]);

        User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role

        ]);

        return redirect('/admin/users');
    }


    public function edit($id)
    {

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $request->validate([

            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'

        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // jika password diisi maka update password
        if ($request->password) {

            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('/admin/users')->with('success', 'User berhasil diperbarui');
    }


    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $user->delete();

        return redirect('/admin/users');
    }
}
