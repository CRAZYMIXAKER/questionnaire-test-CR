<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::any('{all}', function () {
    $user = Auth::user();
    return view('vue')->with(compact('user'));
})->where(['all' => '.*']);
