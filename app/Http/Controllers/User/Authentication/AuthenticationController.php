<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {

        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'confirmPassword' => 'required|same:password'
            ]);

            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
  
            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully',
                'data' => $user
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'failure',
                'message' => 'User registration failed' .$e,
                'data' => null,
            ], 401);
        }
    }
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
