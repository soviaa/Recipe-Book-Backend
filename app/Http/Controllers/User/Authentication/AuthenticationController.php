<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        try{
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();
            if(! Hash::check($credentials['password'], $user->password)){
                return response()->json([
                    'message' => 'Invalid credentials'], 401);
            }
            $token = $user->createToken('token-name')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'message' => 'Login successful',
                'data' => $user
                ], 200);

        }
        catch(\Exception $e)
        {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()], 500);
        }
    }
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the user panel'], 200);
    }

}
