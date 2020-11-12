<?php

namespace App\Http\Controllers\V1\V1;

use App\Http\Controllers\V1\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(User $user, Post $post): JsonResponse
    {
        return response()->json([
            'data' => $post->comments()
        ], 200);
    }

    public function create(User $user, Post $post): JsonResponse
    {
        return response()->json([
            'data' => 'ok form',
            'userId' => $user->id,
            'postId' => $post->id
        ], 200);
    }

    public function store(User $user, Post $post, Request $request): JsonResponse
    {
        $data = $request->all();

        if (!isset($data['text'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $comment = new Comment();
        $comment->text = $data['text'];
        $comment->save();

        return response()->json([
            'data' => 'Comment has been posted'
        ], 200);
    }

    public function show(User $user, Post $post, Comment $comment): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'user' => $user,
            'post' => $post,
            'comment' => $comment
        ], 200);
    }

    public function edit(User $user, Post $post, Comment $comment): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'user' => $user,
            'post' => $post,
            'comment' => $comment
        ], 200);
    }

    public function update(User $user, Post $post, Comment $comment, Request $request): JsonResponse
    {
        $data = $request->all();

        if (!isset($data['text'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $comment->text = $data['text'];
        $comment->save();

        return response()->json([
            'data' => 'Updated'
        ], 200);
    }

    public function destroy(User $user, Post $post, Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'data' => 'Deleted',
        ], 204);
    }
}
