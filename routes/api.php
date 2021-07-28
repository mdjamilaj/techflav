<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/forget-mail-send', [AuthController::class, 'forgetMailSend'])->name('forget-mail-send');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});