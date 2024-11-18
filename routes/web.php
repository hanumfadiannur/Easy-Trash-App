<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('start');
});



Route::get('/homeUser', [AccountController::class, 'homeUser'])->name('home.homeUser');;
Route::get('/homeRO', [AccountController::class, 'homeRO'])->name('home.homeRO');;

Route::get('/map', [MapController::class, 'index']);
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
        Route::get('/maps', [TrashController::class, 'locationRO'])->name('maps');
        Route::post('/createwasterequest', [TrashController::class, 'createWasteRequest'])->name('createwasterequest');
        Route::get('/input-weight', [TrashController::class, 'inputWeight'])->name('inputWeight');
        Route::post('/waste/store', [TrashController::class, 'storeData'])->name('storeData');
    });
});
