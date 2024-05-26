<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUser($username){
        $user = User::where('username', $username)->first();
        if ($user->image) {
            // Generate the image URL
            $imageUrl = Storage::url($user->image);
            $user->image = asset($imageUrl);
        }

         return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully',
            'data' => $user
        ], 200);
    }
}
