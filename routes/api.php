<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\QRController;
use App\Http\Controllers\Api\ProfileController;

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


    Route::get("profile",[ProfileController::class, 'show']);
    Route::post("profile",[ProfileController::class, 'update']);
    Route::post("profile-delete",[ProfileController::class, 'destroy']);


    Route::get("notifications",[PublicController::class, "notifications"]);

    Route::post("generate-qr",[QRController::class, "storeQR"]);
    Route::post("store-num-guests",[QRController::class, "storeNumGuests"]);

    Route::get("visit-histories",[PublicController::class, "visitHistories"]);

    Route::post("start-payment", [SubscriptionController::class, 'startPayment']);
    Route::post("change-plan", [SubscriptionController::class, 'changePlan']);
    Route::post("switch-plan", [SubscriptionController::class, 'switchPlan']);

    Route::post("cancel-subscription", [SubscriptionController::class, 'cancelSubscription']);

});
Route::get("plans",[PublicController::class, "plans"]);
Route::get("static-contents",[PublicController::class, "staticContent"]);
Route::get("onboarding-screens",[PublicController::class, "onBoardingScreen"]);
Route::match(['get', 'post'], '/kapri/event', [QRController::class, 'handle']);
Route::post("payment/notify", [SubscriptionController::class, 'notify']);
Route::post("check-vat-status",[SubscriptionController::class, 'checkVatStatus']);
Route::post("contact-message",[PublicController::class, "storeContactMessages"]);
