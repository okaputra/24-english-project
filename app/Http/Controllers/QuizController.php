<?php

namespace App\Http\Controllers;

use App\Models\tb_courses as Course;
use App\Models\tb_sub_courses as Sub;
use App\Models\tb_quiz as Quiz;
use App\Models\tb_user_purchase as UserPurchase;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use App\Models\tb_users as User;
use App\Models\tb_soal as Soal;
use Session;
use Carbon\Carbon;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function StartQuiz($id_quiz, $id_sub_course){
        $quiz = Quiz::find($id_quiz);
        $paket = Paket::find($quiz->id_paket);
        $soal_terpilih = PaketTerpilih::where('id_paket', $paket->id)->get();
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->get();
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();
        return view('main.start-quiz', [
            'quiz' => $quiz,
            'soal' => $soal,
            'jumlah_soal' => $jumlah_soal,
        ]);
    }
}
