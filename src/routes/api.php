<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CommentController;
use App\Http\Controllers\V1\PostController;
use App\Http\Controllers\V1\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('', [AuthController::class, 'authorizeClient']);
        Route::get('callback', [AuthController::class, 'getAccessToken'])->name('access-token');
    });

    Route::middleware(['auth', 'api'])->group(function () {
        Route::resource('users.profile', ProfileController::class);
        Route::resource('users.posts', PostController::class);
        Route::resource('users.profile-list', ProfileController::class);
        Route::resource('users.posts.comments', CommentController::class);
    });

});
