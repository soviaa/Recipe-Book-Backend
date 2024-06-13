<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\Admin\Authentication\AuthenticationController@login');
Route::post('/user/register', 'App\Http\Controllers\User\Authentication\AuthenticationController@register');
Route::post('/user/reset-password', 'App\Http\Controllers\User\Authentication\AuthenticationController@resetPassword')->middleware('auth:sanctum');
Route::post('/user/update', 'App\Http\Controllers\User\Authentication\AuthenticationController@update')->middleware('auth:sanctum');
Route::get('/user/profile', 'App\Http\Controllers\User\Authentication\AuthenticationController@index')->middleware('auth:sanctum');
Route::get('/user/setting', 'App\Http\Controllers\User\Authentication\AuthenticationController@getUserSetting')->middleware('auth:sanctum');
Route::post('/user/setting', 'App\Http\Controllers\User\Authentication\AuthenticationController@updateSetting')->middleware('auth:sanctum');

Route::get('/user/{username}', 'App\Http\Controllers\User\UserController@getUser');

Route::post('/user/login', 'App\Http\Controllers\User\Authentication\AuthenticationController@login');
Route::get('/user/index', 'App\Http\Controllers\User\Authentication\AuthenticationController@index')->middleware('auth:sanctum');

Route::get('/recipe', 'App\Http\Controllers\RecipeController@index');
Route::post('/recipe', 'App\Http\Controllers\RecipeController@addRecipe')->middleware('auth:sanctum');
// Route::post('/recipe/{recipe}/ingredient', [RecipeController::class, 'addIngredient'])->middleware('auth:sanctum');

Route::get('/ingredient', 'App\Http\Controllers\IngredientController@index');
Route::get('/unit', 'App\Http\Controllers\UnitController@index');

Route::get('/category', 'App\Http\Controllers\CategoryController@index');
Route::get('/recipe/{id}', 'App\Http\Controllers\RecipeController@recipeSingle');

Route::get('/comment', 'App\Http\Controllers\User\CommentsController@index');
Route::get('/comment/{id}', 'App\Http\Controllers\User\CommentsController@commentSingle');

Route::post('/user/tfa/generate', 'App\Http\Controllers\Auth\TfaController@twoFactorGenerate')->middleware('auth:sanctum');
Route::post('/user/tfa/verify', 'App\Http\Controllers\Auth\TfaController@twoFactorVerify')->middleware('auth:sanctum');
Route::post('/user/tfa/disable', 'App\Http\Controllers\Auth\TfaController@twoFactorDisable')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/notifications/{user}', [FollowController::class, 'SendNotification']);
    Route::post('/follow/{userId}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{userId}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::get('/followers/{userId}', [FollowController::class, 'followers'])->name('followers');
    Route::get('/followees/{userId}', [FollowController::class, 'followees'])->name('followees');
    Route::get('/follow/{userId}/status', [FollowController::class, 'checkFollowStatus'])->name('follows');

    Route::post('/comment/{id}/reply', 'App\Http\Controllers\User\CommentsController@replyStore');
    Route::post('/comment', 'App\Http\Controllers\User\CommentsController@store');

});

Route::get('/ml', 'App\Http\Controllers\MachineLearning\GeminiTestController@index');
Route::get('/ml/image', 'App\Http\Controllers\MachineLearning\GeminiTestController@imageIdentifier');
