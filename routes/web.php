<?php

use App\Http\Controllers\MembershipRequests;
use App\Http\Controllers\OnboardingScreenController;
use App\Http\Controllers\ProfileController;
use App\Models\OnboardingScreen;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get("/",[MembershipRequests::class,'index'])->name("requests.index");
    Route::get('/requests/{id}/change-status/{status}', [MembershipRequests::class, 'changeStatus'])
    ->name('requests.changeStatus');

    Route::resource("onboarding-screens",OnboardingScreenController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
