<?php

namespace App\Http\Controllers;

use App\Models\tb_quiz as Quiz;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use App\Models\tb_soal as Soal;
use App\Models\tb_user_attempt_quiz as UserAttemptQuiz;
use Session;
use Carbon\Carbon;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function StartQuiz($id_quiz, $id_sub_course)
    {
        $quiz = Quiz::find($id_quiz);
        $paket = Paket::find($quiz->id_paket);
        $soal_terpilih = PaketTerpilih::where('id_paket', $paket->id)->get();
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->simplePaginate(5);
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();

        // ISIKAN TIMER CEK DURASI (SCHEDULE)

        $currentQuiz = UserAttemptQuiz::where('id_quiz', $id_quiz)->where('id_user', Session::get('id'))->first();
        if ($currentQuiz == null) {
            $attemptQuiz = new UserAttemptQuiz();
            $attemptQuiz->id_user = Session::get('id');
            $attemptQuiz->id_quiz = $id_quiz;
            $attemptQuiz->start = Carbon::now();
            $attemptQuiz->save();
            return view('main.start-quiz', [
                'quiz' => $quiz,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
            ]);
        } elseif ($currentQuiz->end == null) {
            return view('main.start-quiz', [
                'quiz' => $quiz,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
            ]);
        }
        return redirect("/user-get-subcourse-material/$id_quiz/$id_sub_course")->with('info', 'Quiz Telah Selesai, Tekan Re-Attempt Quiz Untuk Memulai Kembali!');
    }
    public function RestartQuiz($id_quiz, $id_sub_course)
    {
        $quiz = Quiz::find($id_quiz);
        $paket = Paket::find($quiz->id_paket);
        $soal_terpilih = PaketTerpilih::where('id_paket', $paket->id)->get();
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->simplePaginate(5);
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();
        $userAttemptData = UserAttemptQuiz::where('id_quiz', $id_quiz)->where('id_user', Session::get('id'))->first();

        // ISIKAN TIMER CEK DURASI (SCHEDULE)

        if ($userAttemptData == null) {
            return redirect()->back()->with('error', 'Quiz Tidak Ditemukan!');
        }
        $userAttemptData->update([
            'end' => NULL
        ]);

        // Update nilai juga disini jika user memutuskan untuk re-attempt quiz, ambil nilai terakhir saja. UPDATE TABLE JAWABAN USERS

        return view('main.start-quiz', [
            'quiz' => $quiz,
            'soal' => $soal,
            'jumlah_soal' => $jumlah_soal,
        ]);
    }
    public function submitQuiz(Request $request, $id_quiz)
    {
        return "Coming Soon";
    }
    public function SimpanJawabanUser(Request $request, $id_quiz)
    {
        return "Coming Soon";
    }
}
