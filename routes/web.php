<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(SocialLoginController::class)->group(function(){
    Route::get('/social-login/google','index')->name('google-login');
    Route::get('/social-login/callback','callback');
    Route::get('/logout','logout');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});