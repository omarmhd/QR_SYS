<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();

})->middleware('auth:sanctum');

Route::post("/register",[AuthController::class, "register"]); 
Route::post("login",[AuthController::class, "login"]);
Route::get("onboarding-screens",[PublicController::class, "onBoardingScreen"]);

Route::get("plans",[PublicController::class, "plans"]);
