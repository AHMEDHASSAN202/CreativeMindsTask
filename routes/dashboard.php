<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest:dashboard'], function () {
    Route::view('login', 'dashboard.auth.login')->name('login');
    Route::post('login', 'AuthController@login')->name('login.submit');
});

Route::group(['middleware' => 'auth:dashboard'], function () {
    Route::post('logout', 'AuthController@logout');
    Route::get('', 'DashboardController')->name('dashboard.index');
    Route::resource('users', 'UserController')->except('show', 'destroy');
    Route::delete('users', 'UserController@delete');
});
