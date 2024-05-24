<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class FollowController extends Controller
{
    // Follow a user
    public function follow($userId)
    {
        try{
            $user = Auth::user();
            if ($user->id == $userId) {
                return response()->json(['message' => 'You cannot follow yourself.']);
            }
            $userToFollow = User::findOrFail($userId);

            if (!$user->followees()->where('followee_id', $userId)->exists()) {
                $user->followees()->attach($userId);
                // Create a notification for the followed user (optional)
                // $userToFollow->notify(new \App\Notifications\FollowNotification($user));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Followed successfully.',
                'data' => 'followed'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
                'data' => 'error'
            ]);
        }

    }

    // Unfollow a user
    public function unfollow($userId)
    {
        try{
            $user = Auth::user();
            $userToUnfollow = User::findOrFail($userId);

            if ($user->followees()->where('followee_id', $userId)->exists()) {
                $user->followees()->detach($userId);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Unfollowed successfully.',
                'data' => 'unfollowed'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
                'data' => 'error'
            ]);
        }

    }

    // Get list of followers
    public function followers($userId)
    {
        $user = User::findOrFail($userId);
        $followers = $user->followers()->get();

        return response()->json($followers);
    }

    // Get list of followees
    public function followees($userId)
    {
        $user = User::findOrFail($userId);
        $followees = $user->followees()->get();

        return response()->json($followees);
    }

    // Check if the authenticated user is following the given user
    public function checkFollowStatus($userId)
    {
        $user = Auth::user();
        $isFollowing = $user->followees()->where('followee_id', $userId)->exists();

        return response()->json([
            'status' => 'success',
            'isFollowing' => $isFollowing,
        ]);
    }
}
