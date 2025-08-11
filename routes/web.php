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



Route::get('/', function () {

    $stats = \App\Models\User::selectRaw("
            SUM(CASE WHEN approval_status = 'pending' THEN 1 ELSE 0 END) as pending_users,
            SUM(CASE WHEN approval_status = 'approved' THEN 1 ELSE 0 END) as active_users,
            COUNT(*) as total_users
        ")->first();

    return view('dashboard',["stats"=>$stats]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource("/users",UserController::class);

    Route::get("/requests",[MembershipRequests::class,'index'])->name("requests.index");
    Route::get('/requests/{id}/change-status/{status}', [MembershipRequests::class, 'changeStatus'])
    ->name('requests.changeStatus');

    Route::delete("requests/{id}",[MembershipRequests::class,"destroy"])->name("requests.destroy");

    Route::resource("onboarding-screens",OnboardingScreenController::class);

    Route::resource("notifications",NotificationController::class);
    Route::resource('/plans', PlanController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/static-contents",[StaticContentController::class,'edit'])->name("static_contents.edit");
    Route::patch("/static-contents",[StaticContentController::class,'update'])->name("static_contents.update");




});

require __DIR__.'/auth.php';
