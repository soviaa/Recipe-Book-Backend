<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser($username){
        $user = User::where('username', $username)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully',
            'data' => $user
        ], 200);
    }
}
