<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthenticationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Check if the user has an image
        if ($user->image) {
            // Generate the image URL
            $imageUrl = Storage::url($user->image);
            $user->image = asset($imageUrl);
        }

        return response()->json([
            'message' => 'Welcome to the user panel',
            'data' => $user,
        ], 200);
    }

    public function register(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'confirmPassword' => 'required|same:password',
            ]);

            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'User registration failed'.$e,
                'data' => null,
            ], 401);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required',
                'confirmPassword' => 'required|same:newPassword',
            ]);

            $user = $request->user();

            if (! Hash::check($request->currentPassword, $user->password)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Current password does not match',
                    'data' => null,
                ], 400);
            }

            $user->password = Hash::make($request->newPassword);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully',
                'data' => $user,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Password update failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Password reset failed'.$e,
            ], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'firstName' => 'sometimes|required',
                'lastName' => 'sometimes|required',
                'username' => 'sometimes|required',
            ]);

            $user = $request->user();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->username = $request->username;

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'User update failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'User update failed' . $e,
            ], 400);
        }
    }

    public function updateImages(Request $request)
    {
        try {
            $request->validate([
                'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg',
                'cover_image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $user = $request->user();

            if ($request->hasFile('image')) {
                $path = $this->storeImage($request->file('image'), 'public/profileImages');
                $user->image = $path;
            }

            if ($request->hasFile('cover_image')) {
                $path = $this->storeImage($request->file('cover_image'), 'public/coverImages');
                $user->cover_image = $path;
            }

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Images updated successfully',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Image update failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Image update failed' . $e,
            ], 400);
        }
    }
    private function storeImage($file, $directory)
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = time();
        $fileExtension = $file->getClientOriginalExtension();
        $newFileName = $filename.'_'.$timestamp.'.'.$fileExtension;
        return $file->storeAs($directory, $newFileName);
    }


    // public function index()
    // {
    //     return response()->json([
    //         'message' => 'Welcome to the user panel'], 200);
    // }
    public function getUserSetting()
    {
        try {
            // Get the currently authenticated user
            $user = auth()->user();

            if ($user === null) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'User is not authenticated',
                ], 401); // 401 Unauthorized
            }

            $settings = Setting::where('user_id', $user->id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'User settings retrieved successfully',
                'data' => $settings,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Failed to retrieve user settings: '.$e->getMessage(),
            ], 400);
        }
    }

    public function updateSetting(Request $request)
    {
        try {
            // Get the currently authenticated user
            $user = auth()->user();

            if ($user === null) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'User is not authenticated',
                ], 401); // 401 Unauthorized
            }

            $setting = Setting::where('user_id', $user->id)->first();

            if ($setting === null) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'User setting not found',
                ], 404); // 404 Not Found
            }

            $setting->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'User setting updated successfully',
                'data' => $setting,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Failed to update user setting: '.$e->getMessage(),
            ], 400);
        }
    }
}
