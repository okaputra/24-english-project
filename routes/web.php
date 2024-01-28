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
Route::get('/login-user', 'App\Http\Controllers\AuthController@index');
Route::post('/login-user', 'App\Http\Controllers\AuthController@loginPost');
Route::get('/register-user', 'App\Http\Controllers\AuthController@register');
Route::post('/register-user', 'App\Http\Controllers\AuthController@registerUser');
Route::get('/logout', 'App\Http\Controllers\AuthController@logout');

// ADMIN ==================
Route::get('/admin-login', 'App\Http\Controllers\AuthController@LoginAdmin');
Route::post('/admin-login', 'App\Http\Controllers\AuthController@PostLoginAdmin');
Route::get('/logout-admin', 'App\Http\Controllers\AuthController@LogoutAdmin');

// AUTH END


// MAIN ROUTE

// USER ==============
Route::get('/', 'App\Http\Controllers\MainController@index');
Route::get('/our-courses', 'App\Http\Controllers\MainController@courses');
Route::get('/detail-course/{id}', 'App\Http\Controllers\MainController@detailCourses');


// MIDDLEWARE CHECKING USER
Route::middleware(['checkLogin'])->group(function () {
    Route::get('/about', 'App\Http\Controllers\MainController@about');
});


// MIDDLEWARE CHECKING ADMIN
Route::middleware(['checkLoginAdmin'])->group(function () {
    Route::get('/admin-dashboard', 'App\Http\Controllers\AdminController@index');
    Route::get('/admin-input-course', 'App\Http\Controllers\AdminController@inputCourse');
    Route::post('/admin-input-course', 'App\Http\Controllers\AdminController@postCourse');
    Route::get('/admin-get-all-course', 'App\Http\Controllers\AdminController@indexCourse');
    Route::get('/admin-detail-course/{id}', 'App\Http\Controllers\AdminController@detailCourse');
    Route::get('/admin-delete-subcourse/{id}', 'App\Http\Controllers\AdminController@deleteSubCourse');
    Route::get('/admin-delete-course/{id}', 'App\Http\Controllers\AdminController@deleteCourse');
    Route::get('/admin-edit-course/{id}', 'App\Http\Controllers\AdminController@UpdateCourse');
    Route::post('/admin-update-course/{id}', 'App\Http\Controllers\AdminController@PostUpdateCourse');
    Route::get('/admin-edit-subcourse/{id}/{id_course}', 'App\Http\Controllers\AdminController@UpdateSubCourse');
    Route::post('/admin-update-subcourse/{id}/{id_course}', 'App\Http\Controllers\AdminController@PostUpdateSubCourse');
    Route::get('/admin-input-sub-course/{id}', 'App\Http\Controllers\AdminController@AddNewSubCourse');
    Route::post('/admin-input-sub-course/{id}', 'App\Http\Controllers\AdminController@PostNewSubCourse');

    // SOAL
    Route::get('/admin-create-soal', 'App\Http\Controllers\AdminContentController@CreateSoal');
    Route::get('/admin-delete-soal/{id}', 'App\Http\Controllers\AdminContentController@DeleteSoal');
    Route::get('/admin-delete-opsi/{id}', 'App\Http\Controllers\AdminContentController@DeleteOpsi');
    Route::get('/admin-update-soal/{id}', 'App\Http\Controllers\AdminContentController@UpdateSoal');
    Route::post('/admin-update-soal/{id}', 'App\Http\Controllers\AdminContentController@PostUpdateSoal');
    Route::post('/admin-create-soal', 'App\Http\Controllers\AdminContentController@PostCreateSoal');

    // PAKET
    Route::get('/admin-create-paket', 'App\Http\Controllers\AdminContentController@CreatePaket');
    Route::get('/admin-assign-paket/{id}', 'App\Http\Controllers\AdminContentController@AssignPaket');
    Route::post('/admin-assign-paket/{id}', 'App\Http\Controllers\AdminContentController@PostAssignPaket');
    Route::get('/admin-delete-paket/{id}', 'App\Http\Controllers\AdminContentController@DeletePaket');
    Route::get('/admin-update-paket/{id}', 'App\Http\Controllers\AdminContentController@UpdatePaket');
    Route::post('/admin-update-paket/{id}', 'App\Http\Controllers\AdminContentController@PostUpdatePaket');
    Route::post('/admin-create-paket', 'App\Http\Controllers\AdminContentController@PostCreatePaket');

    // SUB COURSE CONTENT
    Route::get('/admin-input-subcourse-content/{id}', 'App\Http\Controllers\AdminContentController@AddNewSubCourseContent');
    Route::post('/admin-input-subcourse-content/{id}', 'App\Http\Controllers\AdminContentController@PostSubCourseContent');

});



