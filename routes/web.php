<?php

use App\Http\Controllers\MembershipRequests;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("requests",[MembershipRequests::class,'index'])->name("requests.index");
Route::get('/requests/{id}/change-status/{status}', [MembershipRequests::class, 'changeStatus'])
    ->name('requests.changeStatus');
