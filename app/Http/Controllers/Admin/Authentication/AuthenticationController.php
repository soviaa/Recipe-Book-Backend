<?php

namespace App\Http\Controllers\Admin\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $user = Admin::where('email', $credentials['email'])->first();
            if (! Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'], 401);
            }
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'message' => 'Login successful'], 200);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the admin panel'], 200);
    }
}
