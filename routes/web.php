<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Middleware\IKNAdmin;
use App\Http\Middleware\IKNAuth;
use App\Http\Middleware\IKNGuest;

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
            Route::get('profile', [UserController::class, 'profile'])->name('profile');
            Route::resource('users', UserController::class)->except(['show', 'update']);
        });
    });
});




Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
