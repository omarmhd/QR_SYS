<?php

use App\Http\Controllers\MembershipRequests;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OnboardingScreenController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticContentController;
use App\Http\Controllers\UserController;
use App\Models\OnboardingScreen;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;


Route::get('/', function () {

    $stats = \App\Models\User::selectRaw("
            SUM(CASE WHEN approval_status = 'pending' THEN 1 ELSE 0 END) as pending_users,
            SUM(CASE WHEN approval_status = 'accepted' THEN 1 ELSE 0 END) as active_users,
            SUM(CASE WHEN approval_status = 'rejected' THEN 1 ELSE 0 END) as reject_users,

            COUNT(*) as total_users
        ")->first();

    $services = \App\Models\Service::selectRaw('
        services.id,
        services.name,
         COUNT(CASE WHEN checked != 1 THEN 1 END) AS total_requests
     ')
        ->leftJoin('service_requests', 'services.id', '=', 'service_requests.service_id')
        ->groupBy('services.id', 'services.name')
        ->get();

    return view('dashboard',["stats"=>$stats,"services"=>$services]);
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/payment-redirect', function (Illuminate\Http\Request $request) {


    return view("redirect-to-app");
});
Route::middleware('auth')->group(function () {

    Route::resource("users",UserController::class);

    Route::get("/requests",[MembershipRequests::class,'index'])->name("requests.index");
    Route::get('/requests/{id}/change-status/{status}', [MembershipRequests::class, 'changeStatus'])
    ->name('requests.changeStatus');

    Route::delete("requests/{id}",[MembershipRequests::class,"destroy"])->name("requests.destroy");

    Route::resource("onboarding-screens",OnboardingScreenController::class);

    Route::resource("notifications",NotificationController::class);
    Route::resource('/plans', PlanController::class);

    Route::get("/static-contents",[StaticContentController::class,'edit'])->name("static_contents.edit");
    Route::patch("/static-contents",[StaticContentController::class,'update'])->name("static_contents.update");

    Route::resource("/lounges",\App\Http\Controllers\LoungeController::class);
    Route::resource("/features",\App\Http\Controllers\FeatureController::class);
    Route::resource("/services",\App\Http\Controllers\ServiceController::class);
    Route::resource("service-requests",\App\Http\Controllers\ServiceRequestController::class);

    Route::post('contact-messages/check/{id}', [\App\Http\Controllers\ContactMessageController::class, 'check'])
        ->name('contact-message.check');
    Route::resource("contact-messages", \App\Http\Controllers\ContactMessageController::class)->only(["index","destroy"]);

    Route::view("members","members.index");
    Route::get('/memberships', [\App\Http\Controllers\MembershipController::class, 'index'])->name('memberships.index');
// web.php
    Route::post('/memberships/{id}/generate-qr', [\App\Http\Controllers\MembershipController::class, 'generateQr']);
    Route::get('/memberships/{id}/history', [\App\Http\Controllers\MembershipController::class, 'history']);

    Route::resource("payments",PaymentController::class);

    Route::get("settings",[SettingsController::class,"index"])->name("settings");
    Route::post("settings",[SettingsController::class,"update"])->name("settings.update");

    Route::get("profile",[\App\Http\Controllers\AdminController::class,"index"])->name("profile");
    Route::post("profile",[\App\Http\Controllers\AdminController::class,"update"])->name("profile.update");

    Route::post('/service-requests/{id}/notes', [\App\Http\Controllers\ServiceRequestController::class, 'storeNote'])->name('service-requests.notes');
    Route::get('/service-requests/{id}/notes', [\App\Http\Controllers\ServiceRequestController::class, 'getNote'])->name('service-requests.getNote');
    Route::post('/service-requests/check/{id}', [\App\Http\Controllers\ServiceRequestController::class, 'check'])->name('service-requests.getNote');
});;

require __DIR__.'/auth.php';
