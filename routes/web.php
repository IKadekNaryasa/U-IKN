<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Middleware\IKNAdmin;
use App\Http\Middleware\IKNAuth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth.auth');
Route::get('/changePassword', [AuthController::class, 'changePasswordView'])->name('auth.changePasswordView');
Route::post('/changePassword', [AuthController::class, 'changePassword'])->name('auth.changePassword');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(IKNAuth::class)->group(function () {

    Route::middleware(IKNAdmin::class)->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', UserController::class)->except('show');
        });
    });
});




Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
