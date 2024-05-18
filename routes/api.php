<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\Admin\Authentication\AuthenticationController@login');
Route::post('/user/login', 'App\Http\Controllers\Admin\Authentication\AuthenticationController@login');
Route::post('/user/register', 'App\Http\Controllers\User\Authentication\AuthenticationController@register');
Route::post('/user/reset-password', 'App\Http\Controllers\User\Authentication\AuthenticationController@resetPassword')->middleware('auth:sanctum');
Route::post('/user/update', 'App\Http\Controllers\User\Authentication\AuthenticationController@update')->middleware('auth:sanctum');
Route::get('/user/profile', 'App\Http\Controllers\User\Authentication\AuthenticationController@index')->middleware('auth:sanctum');


Route::post('/user/login', 'App\Http\Controllers\User\Authentication\AuthenticationController@login');
// Route::get('/user/index', 'App\Http\Controllers\User\Authentication\AuthenticationController@index')->middleware('auth:sanctum');

Route::get('/recipe', 'App\Http\Controllers\RecipeController@index');

Route::get('/category', 'App\Http\Controllers\CategoryController@index');
Route::get('/recipe/{id}', 'App\Http\Controllers\RecipeController@recipeSingle');

Route::get('/comment', 'App\Http\Controllers\User\CommentsController@index');
Route::get('/comment/{id}', 'App\Http\Controllers\User\CommentsController@commentSingle');
