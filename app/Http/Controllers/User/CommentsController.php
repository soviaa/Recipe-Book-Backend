<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $comment = Comment::with('user', 'replies.user')->where('recipe_id', $id)->get()->toArray();
     
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

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'recipe_id' => 'required'
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = 2;
        $comment->recipe_id = $request->recipe_id;
        $comment->save();

        $comment = Comment::with('user')->where('id', $comment->id)->get()->toArray();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment added successfully',
            'data' => $comment
        ], 201);
    }

    public function replyStore(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required',
        ]);

        $reply = new CommentReply();
        $reply->reply = $request->reply;
        $reply->user_id = 1;
        $reply->comment_id = $id;
        $reply->save();

        $reply = CommentReply::with('user')->where('id', $reply->id)->get()->toArray();

        return response()->json([
            'status' => 'success',
            'message' => 'Reply added successfully',
            'data' => $reply
        ], 201);
    }
}
