<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\ProfileList;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileListController extends Controller
{
    public function index(User $user): JsonResponse
    {
        return response()->json([
            'data' => $user->profiles()
        ], 200);
    }

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

        if (!isset($data['list'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $list = new ProfileList();
        $list->owner_user_id = $user->id;
        $list->list = $data['list'];
        $list->save();

        return response()->json([
            'data' => 'Profile list has been created'
        ], 200);
    }

    public function show(User $user, ProfileList $profileList): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'profile' => $user,
            'post' => $profile
        ], 200);
    }

    public function edit(User $user, ProfileList $profileList): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'user' => $user,
            'post' => $profile
        ], 200);
    }

    public function update(User $user, ProfileList $profileList, Request $request): JsonResponse
    {
        $data = $request->all();

        if (!isset($data['list'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $profileList->list = $data['list'];
        $profileList->save();

        return response()->json([
            'data' => 'Updated'
        ], 200);
    }

    public function destroy(User $user, ProfileList $profileList): JsonResponse
    {
        $profileList->delete();

        return response()->json([
            'data' => 'Deleted',
        ], 204);
    }
}
