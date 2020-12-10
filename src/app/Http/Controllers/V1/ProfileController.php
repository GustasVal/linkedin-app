<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(User $user): JsonResponse
    {
        return response()->json([
            'data' => $user->profiles()->get()->toArray()
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

        if (!isset($data['email']) || !isset($data['address'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->email = $request->input('email', '');
        $profile->last_name = $request->input('last_name', '');
        $profile->address = $request->input('address', '');
        $profile->number = $request->input('number', '');
        $profile->save();

        return response()->json([
            'data' => 'Profile has been created',
            'id' => $profile->id
        ], 200);
    }

    public function show(User $user, Profile $profile): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'profile' => $user,
            'post' => $profile
        ], 200);
    }

    public function edit(User $user, Profile $profile): JsonResponse
    {
        return response()->json([
            'data' => 'Ok',
            'user' => $user,
            'post' => $profile
        ], 200);
    }

    public function update(User $user, Profile $profile, Request $request): JsonResponse
    {
        $data = $request->all();

        if (!isset($data['email']) || !isset($data['address'])) {
            return response()->json([
                'data' => 'Some data is missing'
            ], 400);
        }

        $profile->email = $request->input('email', '');
        $profile->last_name = $request->input('last_name', '');
        $profile->address = $request->input('address', '');
        $profile->number = $request->input('number', '');
        $profile->save();

        return response()->json([
            'data' => 'Updated'
        ], 200);
    }

    public function destroy(User $user, Profile $profile): JsonResponse
    {
        $profile->delete();

        return response()->json([
            'data' => 'Deleted',
        ], 204);
    }
}
