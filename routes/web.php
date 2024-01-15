<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Route
Route::get('/','App\Http\Controllers\MainController@index');
Route::get('/logout','App\Http\Controllers\AuthController@logout');

Route::middleware(['checkLogin'])->group(function(){
    Route::get('/about','App\Http\Controllers\MainController@about');
    Route::get('/our-courses','App\Http\Controllers\MainController@courses');
    Route::get('/detail-courses','App\Http\Controllers\MainController@detailCourses');
});

// Auth Route
Route::get('/login-user','App\Http\Controllers\AuthController@index');
Route::post('/login-user','App\Http\Controllers\AuthController@loginPost');
Route::get('/register-user','App\Http\Controllers\AuthController@register');
Route::post('/register-user','App\Http\Controllers\AuthController@registerUser');
