<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($user, $post, $comment)
    {
        if (!is_numeric($comment)) {
            return response()->json([
                'data' => 'error'
            ], 400);
        }

        return response()->json([
            'data' => 'ok show',
            'profileId' => $user,
            'postId' => $post,
            'commentId' => $comment
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        return response()->json([
            'data' => 'ok create'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store($user, $post, $comment)
    {
        if (!is_numeric($comment)) {
            return response()->json([
                'data' => 'error'
            ], 404);
        }

        return response()->json([
            'data' => 'ok updated',
            'profileId' => $user,
            'postId' => $post,
            'commentId' => $comment
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            'data' => 'ok show'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        return response()->json([
            'data' => 'ok edit'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        return response()->json([
            'data' => 'ok update'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($user, $post, $comment)
    {
        if (!is_numeric($comment)) {
            return response()->json([
                'data' => 'error'
            ], 400);
        }

        return response()->json([
            'data' => 'ok destroyed',
            'profileId' => $user,
            'postId' => $post,
            'commentId' => $comment
        ], 204);
    }
}
