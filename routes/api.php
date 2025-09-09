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
Route::post("logout",[AuthController::class, "logout"])->middleware('auth:sanctum');

Route::get("onboarding-screens",[PublicController::class, "onBoardingScreen"]);
Route::get("static-contents",[PublicController::class, "staticContent"]);
Route::get("lounges",[PublicController::class,"lounges"]);

Route::get("plans",[PublicController::class, "plans"]);
Route::post("private-requests",[PublicController::class, "storePrivateService"]);

Route::match(['get', 'post'], '/kapri/event', [\App\Http\Controllers\Api\KapriEventController::class, 'handle']);
