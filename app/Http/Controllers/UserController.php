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
}
