<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::any('{all}', function () {
    $user = Auth::user();
    return view('vue')->with(compact('user'));
})->where(['all' => '.*']);

//Auth::routes(['verify' => true]);
