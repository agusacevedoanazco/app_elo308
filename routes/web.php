<?php

use Illuminate\Support\Facades\Route;

/** Public Controllers */

/** Auth Controllers */
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

/** Admin Controllers */
use App\Http\Controllers\Admin\HomeController as AdminHomeController;

/** User Controllers */
use App\Http\Controllers\User\HomeController as UserHomeController;
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

Route::get('/', function () {
    return view('welcome');
});

/** Public Routes */
Route::get('/', function(){ return view('public.welcome'); });
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

/** Authenticated Routes */
Route::group(['middleware'=>'auth'], function (){
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    /** Admin Routes */
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('/home', [AdminHomeController::class, 'index'])->name('homepage');
    });

    /** User Routes */
    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'user'], function(){
        Route::get('/home', [UserHomeController::class, 'index'])->name('homepage');
    });
});


