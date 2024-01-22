<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});
Route::resource('product', ProductController::class)->middleware('auth:sanctum');
Route::resource('category', CategoryController::class)->middleware('auth:sanctum');
Route::post('create-user', [\App\Http\Controllers\Auth\RegisterController::class, 'createUser']);
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
//Route::post('/logout', 'Auth\LoginController@logout');
