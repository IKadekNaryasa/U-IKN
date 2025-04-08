<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Head\DashboardController as HeadDashboard;
use App\Http\Controllers\Technician\DashboardController as TechnicianDashboard;
use App\Http\Middleware\IKNAdmin;
use App\Http\Middleware\IKNAuth;
use App\Http\Middleware\IKNGuest;
use App\Http\Middleware\IKNHead;
use App\Http\Middleware\IKNTechnician;

Route::get('/helloIkn-uui', function () {
    return view('welcome');
});

Route::middleware(IKNGuest::class)->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth.index');
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth.auth');
});
Route::middleware(IKNAuth::class)->group(function () {
    Route::get('/changePassword', [AuthController::class, 'changePasswordView'])->name('auth.changePasswordView');
    Route::put('/changePassword', [AuthController::class, 'changePassword'])->name('auth.changePassword');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::put('user/update/{user}', [AuthController::class, 'update'])->name('user.update');

    Route::middleware(IKNAdmin::class)->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('profile', [UserController::class, 'profile'])->name('profile');
            Route::resource('users', UserController::class)->except(['show', 'update']);
        });
    });

    Route::middleware(IKNHead::class)->group(function () {
        Route::prefix('head')->name('head.')->group(function () {
            Route::get('/dashboard', [HeadDashboard::class, 'index'])->name('dashboard.index');
            Route::get('/user', [HeadDashboard::class, 'users'])->name('users');
            Route::get('/profile', [HeadDashboard::class, 'profile'])->name('profile');
        });
    });


    Route::middleware(IKNTechnician::class)->group(function () {
        Route::prefix('technician')->name('technician.')->group(function () {
            Route::get('/profile', [TechnicianDashboard::class, 'profile'])->name('profile');
        });
    });
});


Route::get('/fogotPassword', [AuthController::class, 'forgotPassword'])->name('auth.forgotPassword');
Route::put('/sendPassword', [AuthController::class, 'sendNewPassword'])->name('auth.sendPassword');

Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
