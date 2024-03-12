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
Route::get('/detail-subcourse/{id}', 'App\Http\Controllers\MainController@detailSubCourse');
Route::get('/about', 'App\Http\Controllers\MainController@about');


// MIDDLEWARE CHECKING USER
Route::middleware(['checkLogin'])->group(function () {
    // ================================== ROUTE UNTUK PERSONAL COURSES (PAID) ======================================
    Route::get('/my-courses', 'App\Http\Controllers\MainController@MyCourses');
    Route::get('/detail-my-subcourse/{id}', 'App\Http\Controllers\MainController@detailSubCourse');

    // ================================== ROUTE UNTUK PAYMENT ======================================
    Route::get('/user-get-subcourse-material/{id_quiz}/{id_sub_course}', 'App\Http\Controllers\MainController@getSubCourseContent')->middleware('checkUserPurchase');
    Route::get('/user-get-tryout/{id_tryout}/{id_sub_course}', 'App\Http\Controllers\MainController@getSubCourseTryout')->middleware('checkUserPurchase');
    Route::post('/user-rate-subcourse-material/{id_sub_course}', 'App\Http\Controllers\MainController@rateSubCourseContent')->middleware('checkUserPurchase');
    Route::get('/user-get-free-subcourse-material/{id_quiz}/{id_sub_course}', 'App\Http\Controllers\MainController@getSubCourseContent')->middleware('checkFreeCourse');
    Route::get('/user-buy-subcourse/{id_sub_course}', 'App\Http\Controllers\MainController@buySubCourse')->middleware('checkPaidSubCourse');
    Route::post('/user-confirm-subcourse/{id_sub_course}', 'App\Http\Controllers\MainController@confirmSubCourse')->middleware('checkPaidSubCourse');
    Route::post('/user-pay-subcourse/{id_sub_course}', 'App\Http\Controllers\MainController@paySubCourse')->middleware('checkPaidSubCourse');
    Route::get('/user-invoice-subcourse/{id_sub_course}/{id_order}', 'App\Http\Controllers\MainController@Invoice');

    // INI ROUTE YANG DIBERIKAN KE CONFIGURASI WEB HOOK MIDTRANS. ROUTE INI DITEMPATKAN DI API AGAR TIDAK PERLU CSRF TOKEN
    // Route::post('/user-midtrans-webhook-subcourse', 'App\Http\Controllers\MainController@paySubCourse');

    // ================================== ROUTE UNTUK QUIZ ======================================
    Route::get('/user-attempt-quiz/{id_quiz}/{id_sub_course}', 'App\Http\Controllers\QuizController@StartQuiz')->middleware('checkUserPurchase');
    Route::get('/user-reattempt-quiz/{id_quiz}/{id_sub_course}', 'App\Http\Controllers\QuizController@RestartQuiz')->middleware('checkUserPurchase');
    Route::get('/user-get-result-quiz/{id_quiz}/{id_sub_course}', 'App\Http\Controllers\QuizController@GetQuizResult')->middleware('checkUserPurchase');
    Route::post('/save-answer', 'App\Http\Controllers\QuizController@SimpanJawabanUser')->name('save-answer');
    Route::post('/user-submit-quiz/{id_quiz}/{id_sub_course}', 'App\Http\Controllers\QuizController@submitQuiz');

    // ================================== ROUTE UNTUK TRYOUT ======================================
    Route::get('/user-attempt-tryout/{id_tryout}/{id_sub_course}', 'App\Http\Controllers\TryoutController@StartTryout')->middleware('checkUserPurchase');
    Route::get('/user-reattempt-tryout/{id_tryout}/{id_sub_course}', 'App\Http\Controllers\TryoutController@RestartTryout')->middleware('checkUserPurchase');
    Route::get('/user-get-result-tryout/{id_tryout}/{id_sub_course}', 'App\Http\Controllers\TryoutController@GetResultTryout')->middleware('checkUserPurchase');
    // Route::post('/save-answer', 'App\Http\Controllers\TryoutController@SaveAnswer')->name('save-answer');
    Route::post('/user-submit-tryout/{id_tryout}/{id_sub_course}', 'App\Http\Controllers\TryoutController@submitTryout');
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
    Route::get('/admin-input-evaluasi/{id_sub_course}', 'App\Http\Controllers\AdminController@AdminInputEvaluasi');
    Route::post('/admin-input-sub-course/{id}', 'App\Http\Controllers\AdminController@PostNewSubCourse');

    // SOAL
    Route::get('/admin-create-soal', 'App\Http\Controllers\AdminContentController@CreateSoal');
    Route::get('/admin-delete-soal/{id}', 'App\Http\Controllers\AdminContentController@DeleteSoal');
    Route::get('/admin-delete-opsi/{id}', 'App\Http\Controllers\AdminContentController@DeleteOpsi');
    Route::get('/admin-delete-audio-soal/{id}', 'App\Http\Controllers\AdminContentController@DeleteAudioSoal');
    Route::get('/admin-delete-audio-opsi/{id}', 'App\Http\Controllers\AdminContentController@DeleteAudioOpsi');
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
    Route::get('/admin-update-subcourse-content/{id}', 'App\Http\Controllers\AdminContentController@UpdateSubCourseContent');
    Route::post('/admin-update-subcourse-content/{id}', 'App\Http\Controllers\AdminContentController@PostUpdateSubCourseContent');
    Route::get('/admin-delete-subcourse-content/{id}', 'App\Http\Controllers\AdminContentController@DeleteSubCourseContent');

    // TRYOUT
    Route::get('/admin-assign-tryout/{id_sub_course}', 'App\Http\Controllers\AdminManageTryoutController@AdminCreateTryout');
    Route::post('/admin-assign-tryout/{id_sub_course}', 'App\Http\Controllers\AdminManageTryoutController@AdminPostTryout');
    Route::get('/admin-update-tryout/{id_tryout}', 'App\Http\Controllers\AdminManageTryoutController@AdminUpdateTryout');
    Route::post('/admin-update-tryout/{id_tryout}', 'App\Http\Controllers\AdminManageTryoutController@AdminPostUpdateTryout');
    Route::get('/admin-delete-tryout/{id_tryout}', 'App\Http\Controllers\AdminManageTryoutController@AdminDeleteTryout');

    // EXAM
    Route::get('/admin-assign-exam/{id_sub_course}', 'App\Http\Controllers\AdminManageExamController@AdminCreateExam');
    Route::post('/admin-assign-exam/{id_sub_course}', 'App\Http\Controllers\AdminManageExamController@AdminPostExam');
    Route::get('/admin-update-exam/{id_exam}', 'App\Http\Controllers\AdminManageExamController@AdminUpdateExam');
    Route::post('/admin-update-exam/{id_exam}', 'App\Http\Controllers\AdminManageExamController@AdminPostUpdateExam');
    Route::get('/admin-delete-exam/{id_exam}', 'App\Http\Controllers\AdminManageExamController@AdminDeleteExam');


});



