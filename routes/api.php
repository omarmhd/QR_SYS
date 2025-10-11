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
    Route::group(["middleware"=>"auth:sanctum"],function (){
    Route::get("onboarding-screens",[PublicController::class, "onBoardingScreen"]);
    Route::get("static-contents",[PublicController::class, "staticContent"]);
    Route::get("lounges",[PublicController::class,"lounges"]);

    Route::get("plans",[PublicController::class, "plans"]);
    Route::post("private-requests",[PublicController::class, "storePrivateService"]);



    Route::get("profile",[\App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::post("profile",[\App\Http\Controllers\Api\ProfileController::class, 'update']);


    Route::get("notifications",[PublicController::class, "notifications"]);
    Route::post("contact-message",[PublicController::class, "storeContactMessages"]);

    Route::post("generate-qr",[\App\Http\Controllers\Api\QRController::class, "storeQR"]);
    Route::post("store-num-guests",[\App\Http\Controllers\Api\QRController::class, "storeNumGuests"]);

        Route::get("visit-histories",[PublicController::class, "visitHistories"]);

});
Route::get("plans",[PublicController::class, "plans"]);
Route::get("static-contents",[PublicController::class, "staticContent"]);
Route::get("onboarding-screens",[PublicController::class, "onBoardingScreen"]);
Route::post("test-payment", [\App\Http\Controllers\PaymentController::class, 'startPayment']);
Route::match(['get', 'post'], '/kapri/event', [\App\Http\Controllers\Api\QRController::class, 'handle']);
