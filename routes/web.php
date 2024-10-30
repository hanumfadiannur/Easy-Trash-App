<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('start');
});

Route::get('/map', [MapController::class, 'index']);
Route::get('/maps', [MapController::class, 'index2']);
Route::get('/form', [MapController::class, 'showForm'])->name('show.form');
Route::post('/get-distance', [MapController::class, 'getDistance'])->name('get.distance');
Route::post('/calculate-distances', [MapController::class, 'calculateDistances'])->name('calculate.distances');



Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('register', [AccountController::class, 'register'])->name('account.register');
        Route::post('register', [AccountController::class, 'processRegister'])->name('account.processRegister');
        Route::get('login', [AccountController::class, 'login'])->name('account.login');
        Route::post('login', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    });
});
