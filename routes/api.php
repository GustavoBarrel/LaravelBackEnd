<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/user/{email}/send-code', [UserController::class,'SendUserLoginValidationTokenByEmail']);
Route::post('/user', [UserController::class,'store']);

