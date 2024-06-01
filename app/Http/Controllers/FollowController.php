<?php

namespace App\Http\Controllers;

use App\Events\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


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
//            $userToFollow = User::findOrFail($userId);

            if (!$user->followees()->where('followee_id', $userId)->exists()) {
                $user->followees()->attach($userId);
                // Create a notification for the followed user (optional)
                // $userToFollow->notify(new \App\Notifications\FollowNotification($user));
            }
            $message = 'has followed your profile!';

            $fullname = $user->firstName . " " . $user->lastName;
            event(new UserFollowed($message, $userId, $user->image, $fullname));

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
        // dd($followers);

        foreach($followers as $follower){
            if ($follower->image) {
                // Generate the image URL
                $imageUrl = Storage::url($follower->image);
                $follower->image = asset($imageUrl);
            }
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Followers fetched successfully.',
                'data' => $followers,
            ]);
    }

    // Get list of followees
    public function followees($userId)
    {
        $user = User::findOrFail($userId);
        $followees = $user->followees()->get();

      foreach($followees as $followee){
            if ($followee->image) {
                // Generate the image URL
                $imageUrl = Storage::url($followee->image);
                $followee->image = asset($imageUrl);
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Followees fetched successfully.',
            'data' => $followees
            ]);
    }

    // Check if the authenticated user is following the given user
    public function checkFollowStatus($userId)
    {
        $user = Auth::user();
        $isFollowing = $user->followees()->where('followee_id', $userId)->exists();

        return response()->json([
            'status' => 'success',
            'message' => 'Follow status checked successfully.',
            'isFollowing' => $isFollowing,
        ]);
    }



    public function SendNotification($user)
    {

        $message = 'You have a new follower';
        event(new UserFollowed($message));

        return response()->json([
            'status' => 'success',
            'message' => 'Notification sent successfully',
            'data' => null
        ]);
    }
}
