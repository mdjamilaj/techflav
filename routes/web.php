<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductPlatformController;
use App\Http\Controllers\ContactController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/email', function () {
    return view('emails.forgetOtpSend');
});
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Auth::routes();

// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
	Route::resource('contact', ContactController::class);
    Route::resource('productTypes', ProductTypeController::class);
	Route::resource('productCategory', ProductCategoryController::class);
	Route::resource('productPlatform', ProductPlatformController::class);

	/***********  Review ************/
	Route::get('review/index/{product_id}', [ReviewController::class, 'index'])->name('review.index');
	Route::get('review/create/{product_id}', [ReviewController::class, 'create'])->name('review.create');
	Route::post('review/store/{product_id}', [ReviewController::class, 'store'])->name('review.store');
	Route::get('review/{id}/edit/{product_id}', [ReviewController::class, 'edit'])->name('review.edit');
	Route::get('review/{id}/show/{product_id}', [ReviewController::class, 'show'])->name('review.show');
	Route::post('review/{id}/update/{product_id}', [ReviewController::class, 'update'])->name('review.update');
	Route::delete('review/{id}/destroy/{product_id}', [ReviewController::class, 'destroy'])->name('review.destroy');
});
