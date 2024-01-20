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

// AUTH START

// USER ==================
Route::get('/login-user','App\Http\Controllers\AuthController@index');
Route::post('/login-user','App\Http\Controllers\AuthController@loginPost');
Route::get('/register-user','App\Http\Controllers\AuthController@register');
Route::post('/register-user','App\Http\Controllers\AuthController@registerUser');
Route::get('/logout','App\Http\Controllers\AuthController@logout');

// ADMIN ==================
Route::get('/admin-login','App\Http\Controllers\AuthController@LoginAdmin');
Route::post('/admin-login','App\Http\Controllers\AuthController@PostLoginAdmin');
Route::get('/logout-admin','App\Http\Controllers\AuthController@LogoutAdmin');

// AUTH END


// MAIN ROUTE

// USER ==============
Route::get('/','App\Http\Controllers\MainController@index');

Route::get('/our-courses','App\Http\Controllers\MainController@courses');
Route::get('/detail-courses','App\Http\Controllers\MainController@detailCourses');


// MIDDLEWARE CHECKING USER
Route::middleware(['checkLogin'])->group(function(){
    Route::get('/about','App\Http\Controllers\MainController@about');
});


// MIDDLEWARE CHECKING ADMIN
Route::middleware(['checkLoginAdmin'])->group(function(){
    Route::get('/admin-dashboard','App\Http\Controllers\AdminController@index');
    Route::get('/admin-input-course','App\Http\Controllers\AdminController@inputCourse');
    Route::post('/admin-input-course','App\Http\Controllers\AdminController@postCourse');
    Route::get('/admin-get-all-course','App\Http\Controllers\AdminController@indexCourse');
});



