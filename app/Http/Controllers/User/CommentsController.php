<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentsController extends Controller
{
    /**
     * Fetches all comments along with the associated user and replies.
     * Each comment's user and replies are eager loaded to minimize the number of queries.
     * The comments are then converted to an array and returned in a JSON response.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $comments = Comment::with('user', 'replies.user')->get()->toArray();

        return response()->json([
            'status' => 'success',
            'message' => 'Comments retrieved successfully',
            'data' => $comments,
        ], 200);
    }

    public function commentSingle($id)
    {
        $comment = Comment::with('user', 'replies.user')
            ->where('recipe_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        foreach ($comment as &$comments) {
            if ($comments['user']['image']) {
                // Generate the image URL
                $imageUrl = Storage::url($comments['user']['image']);
                $comments['user']['image'] = asset($imageUrl);
            }
            foreach ($comments['replies'] as &$reply) {
                if ($reply['user']['image']) {
                    // Generate the image URL
                    $imageUrl = Storage::url($reply['user']['image']);
                    $reply['user']['image'] = asset($imageUrl);
                }
            }
        }
        if ($comment) {
            return response()->json([
                'status' => 'success',
                'message' => 'Comment retrieved successfully',
                'data' => $comment,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Comment not found',
                'data' => null,
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'recipe_id' => 'required',
        ]);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = auth()->user()->id;
        $comment->recipe_id = $request->recipe_id;
        $comment->save();

        $comment = Comment::with('user')->where('id', $comment->id)->get()->toArray();

        foreach ($comment as &$comments) {
            if ($comments['user']['image']) {
                // Generate the image URL
                $imageUrl = Storage::url($comments['user']['image']);
                $comments['user']['image'] = asset($imageUrl);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Comment added successfully',
            'data' => $comment,
        ], 201);
    }

    public function replyStore(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required',
        ]);
        $reply = new CommentReply();
        $reply->reply = $request->reply;
        $reply->user_id = auth()->user()->id;
        $reply->comment_id = $id;
        $reply->save();

        $reply = CommentReply::with('user')->where('id', $reply->id)->get()->toArray();
        foreach ($reply as &$replies) {
            if ($replies['user']['image']) {
                // Generate the image URL
                $imageUrl = Storage::url($replies['user']['image']);
                $replies['user']['image'] = asset($imageUrl);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Reply added successfully',
            'data' => $reply,
        ], 201);
    }
}
