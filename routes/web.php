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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'auth'],function(){
    Route::post('/register','App\Http\Controllers\Auth\RegisterController')->name('register');
    Route::post('/login','App\Http\Controllers\Auth\LoginController')->name('login');
});
