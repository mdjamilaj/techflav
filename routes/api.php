<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CommonController;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/forget-mail-send', [AuthController::class, 'forgetMailSend'])->name('forget-mail-send');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/product/filter', [CommonController::class, 'productFilter'])->name('product_filter');
    Route::get('/product/details/{id}', [CommonController::class, 'productDetails'])->name('product_details');
    Route::get('/product/favourite/{id}', [CommonController::class, 'productfavourite'])->name('product_favourite');
    Route::post('/product/favorite/filter', [CommonController::class, 'productFavoriteFilter'])->name('product_favorite_filter');
    Route::post('/product/review/filter', [CommonController::class, 'productReviewFilter'])->name('product_review_filter');
    Route::post('/product/review', [CommonController::class, 'productReview'])->name('product_review');
    
});