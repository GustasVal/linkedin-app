<?php

namespace App\Http\Controllers\V1\V1;

use App\Http\Controllers\V1\Controller;
use App\Models\LinkedinApi;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function index(User $user): JsonResponse
    {
        return response()->json([
            'data' => $user->posts()
        ], 200);
    }

//
//    This should be a button for share on linkedin
//
//    public function store(Request $request)
//    {
//        /*
//         * This will have to be passed from url
//         */
//        $user = Http::withToken(Session::get('linkedin_access'))->get(LinkedinApi::PROFILE_LINK);;
//
//        return Http::withToken(session('linkedin_access'))->post(LinkedinApi::SHARE_LINK, [
//            'author' => "urn:li:person:{$user['id']}",
//            'lifecycleState' => "PUBLISHED",
//            'specificContent' => [
//                'com.linkedin.ugc.ShareContent' => [
//                    'shareCommentary' => [
//                        "text" => "Hello World! This is my first Share on LinkedIn!"
//                    ],
//                    'shareMediaCategory' => "NONE"
//                ]
//            ],
//            'visibility' => [
//                'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
//            ]
//        ]);
//    }


    public function create(User $user): JsonResponse
    {
        return response()->json([
            'data' => 'ok form',
            'userId' => $user->id
        ], 200);
    }

    public function store(User $user, Request $request): JsonResponse
    {
        $data = $request->all();

        if (!isset($data['title']) || !isset($data['text'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $post = new Post();
        $post->user_id = $user->id;
        $post->title = $request->input('title');
        $post->text = $request->input('text');
        $post->save();

        return response()->json([
            'data' => 'Post has been created'
        ], 200);
    }

    public function show(User $user, Post $post): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'profile' => $user,
            'post' => $post
        ], 200);
    }

    public function edit(User $user, Post $post): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'profile' => $user,
            'post' => $post
        ], 200);
    }

    public function update(User $user, Post $post, Request $request): JsonResponse
    {
        $data = $request->all();

        if (!isset($data['title']) || !isset($data['text'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $post->title = $data['title'];
        $post->text = $data['text'];
        $post->save();

        return response()->json([
            'data' => 'Updated'
        ], 200);
    }

    public function destroy(User $user, Post $post): JsonResponse
    {
        $post->delete();

        return response()->json([
            'data' => 'Deleted',
        ], 204);
    }
}
