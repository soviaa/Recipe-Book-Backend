<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthenticationController extends Controller
{
    public function index(){
        $user= Auth::user();
        return response()->json([
            'message' => 'Welcome to the user panel',
            'data' => $user
        ], 200);
    }
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

    public function resetPassword(Request $request)
    {
        try{
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required',
                'confirmPassword' => 'required|same:newPassword'
            ]);

            $user = $request->user();

            if (!Hash::check($request->currentPassword, $user->password)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Current password does not match',
                    'data' => null
                ], 400);
            }

            $user->password = Hash::make($request->newPassword);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully',
                'data' => $user
            ], 200);
        }
        catch(\Illuminate\Validation\ValidationException $e)
        {
            return response()->json([
                'status' => 'failure',
                'message' => 'Password update failed',
                'errors' => $e->errors(),
            ], 422);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'failure',
                'message' => 'Password reset failed' .$e,
            ], 400);
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
    // public function index()
    // {
    //     return response()->json([
    //         'message' => 'Welcome to the user panel'], 200);
    // }

}
