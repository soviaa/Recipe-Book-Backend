<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user', 'replies.user')->get()->toArray();
        return response()->json([
            'status' => 'success',
            'message' => 'Comments retrieved successfully',
            'data' => $comments
        ], 200);
    }

    public function commentSingle($id)
    {
        $comment = Comment::with('user', 'replies.user')->where('id', $id)->get()->toArray();
        if($comment){
            return response()->json([
                'status' => 'success',
                'message' => 'Comment retrieved successfully',
                'data' => $comment
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'failure',
                'message' => 'Comment not found',
                'data' => null
            ], 404);
        }
    }
}
