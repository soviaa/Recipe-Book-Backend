<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\Admin\Authentication\AuthenticationController@login');
Route::post('/user/login', 'App\Http\Controllers\Admin\Authentication\AuthenticationController@login');


Route::post('/user/login', 'App\Http\Controllers\User\Authentication\AuthenticationController@login');
Route::get('/user/index', 'App\Http\Controllers\User\Authentication\AuthenticationController@index')->middleware('auth:sanctum');

Route::get('/recipe', 'App\Http\Controllers\RecipeController@index');
