<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers(){
        $users = User::with('role', 'userStatus')->get();

        return response()->json(['users' => $users]);
    }

    public function addUser(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'confirm_password' => ['required', 'same:password'],
            'role_id' => ['required', 'exists:roles,id'],
            'user_status_id' => ['required', 'exists:user_statuses,id'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'user_status_id' => $request->user_status_id,
        ]);

        return response()->json(['message' => 'User successfully created!', 'user' => $user]);
    }
}
