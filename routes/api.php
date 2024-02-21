<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/save-answer', function () {
    // Ambil data jawaban dari permintaan
    $questionIndex = request('questionIndex');
    $selectedOption = request('selectedOption');

    // Simpan data jawaban dalam session
    Session::put("user_answers.$questionIndex", $selectedOption);

    // Kirim respons (opsional)
    return response()->json(['success' => true]);
});
