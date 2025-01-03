<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('start');
});


Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        // ROUTE UNTUK REGISTER DAN LOGIN
        Route::get('register', [AccountController::class, 'register'])->name('account.register');
        Route::post('register', [AccountController::class, 'processRegister'])->name('account.processRegister');
        Route::get('login', [AccountController::class, 'login'])->name('account.login');
        Route::post('login', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function () {
        // ROUTE LOGOUT
        Route::get('logout', [AccountController::class, 'logout'])->name('account.logout');

        // ROUTE HOME
        Route::get('/homeUser', [AccountController::class, 'homeUser'])->name('home.homeUser');;
        Route::get('/homeRO', [AccountController::class, 'homeRO'])->name('home.homeRO');;

        //ROUTE PROFILE
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');

        // ROUTE PILIH RECYCLING ORGANIZATION
        Route::get('/maps', [TrashController::class, 'locationRO'])->name('maps');
        Route::post('/createwasterequest', [TrashController::class, 'createWasteRequest'])->name('createwasterequest');

        // ROUTE MEMASUKKAN BERAT SAMPAH
        Route::get('/input-weight', [TrashController::class, 'inputWeight'])->name('inputWeight');
        Route::post('/waste/store', [TrashController::class, 'storeData'])->name('storeData');

        // ROUTE NOTIFICATION REQUEST (HANYA DIAKASES OLEH USER RECYCLING ORGANIZATION)
        Route::get('notification-request', [AccountController::class, 'notificationRequest'])->name('account.notificationRequest');
        Route::get('/notification-request/{id}', [AccountController::class, 'showNotificationRequest'])->name('account.notificationRequest2');
        Route::post('/notification-request/{id}/update-status', [AccountController::class, 'updateStatusRequest'])->name('account.notificationRequest.update');

        // ROUTE MELIHAT RIWAYAT USER YANG SUDAH SELESAI/PERNAH RECYCLING (HANYA DIAKASES OLEH USER RECYCLING ORGANIZATION)
        Route::get('riwayat-recycling', [AccountController::class, 'riwayatRecycling'])->name('account.riwayatRecycling');

        // ROUTE MELIHAT REWARD DAN POINT SERTA MENUKAR REWARD DENGAN POINT (HANYA DIAKASES OLEH USER BIASA)
        Route::get('/reward-and-points', [RewardController::class, 'rewardAndPoint'])->name('pointReward.pointReward');
        Route::post('/redeem-reward', [RewardController::class, 'redeemReward'])->name('reward.redeem');
        Route::get('/reward/transaction/{transaction}', [RewardController::class, 'transactionDetail'])->name('pointReward.transactionDetail');
        Route::get('/your-reward', [RewardController::class, 'yourReward'])->name('pointReward.yourReward');

        // ROUTE MELIHAT SEMUA NOTIFICATION REPORT YAITU POINT YANG MASUK DAN REQUEST YANG DIKIRIM KE RO (HANYA DIAKASES OLEH USER BIASA)
        Route::get('notification-report', [AccountController::class, 'notificationReport'])->name('account.notificationReport');
        Route::get('/notification-report-request/{id}', [AccountController::class, 'showNotificationRequestReport'])->name('account.notificationReport2');
    });
});
