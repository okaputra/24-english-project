<?php

namespace App\Http\Controllers;

use App\Models\tb_quiz as Quiz;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use App\Models\tb_soal as Soal;
use App\Models\tb_user_attempt_quiz as UserAttemptQuiz;
use App\Models\tb_user_answer as UserAnswer;
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
            // Ambil data jawaban dari database, sesuai dengan id pengguna atau id percobaan quiz
            $userAnswers = UserAnswer::where('id_attempt_quiz', $attemptQuiz->id)->pluck('user_answer', 'id_question')->toArray();
            return view('main.start-quiz', [
                'quiz' => $quiz,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentQuiz' => $attemptQuiz,
                'user_answers' => $userAnswers
            ]);
        } elseif ($currentQuiz->end == null) {
            // Ambil data jawaban dari database, sesuai dengan id pengguna atau id percobaan quiz
            $userAnswers = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->pluck('user_answer', 'id_question')->toArray();
            // dd($userAnswers);
            return view('main.start-quiz', [
                'quiz' => $quiz,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentQuiz' => $currentQuiz,
                'user_answers' => $userAnswers
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

        // NANTI RESET JUGA JAWABAN USER PADA TABLE USER ANSWERS

        if ($userAttemptData == null) {
            return redirect()->back()->with('error', 'Quiz Tidak Ditemukan!');
        }
        $userAttemptData->update([
            'end' => NULL
        ]);

        return view('main.start-quiz', [
            'quiz' => $quiz,
            'soal' => $soal,
            'jumlah_soal' => $jumlah_soal,
        ]);
    }
    public function SimpanJawabanUser(Request $request)
    {
        $data = $request->all();

        foreach ($data['user_answers'] as $questionId => $userAnswer) {
            // Cek apakah data sudah ada
            $existingAnswer = UserAnswer::where('id_attempt_quiz', $data['id_attempt_quiz'])
                ->where('id_question', $questionId)
                ->get();

            if ($existingAnswer->isEmpty()) {
                // // Jika belum ada, create data baru
                // $answer = new UserAnswer();
                // $answer->id_attempt_quiz = $data['id_attempt_quiz'];
                // $answer->id_question = $questionId;
                // $answer->user_answer = $userAnswer;
                // $answer->is_correct = 0;
                // // $answer->is_correct = $this->checkAnswer($questionId, $userAnswer);
                // $answer->save();
                foreach ($userAnswer as $index => $answer) {
                    $newAnswer = new UserAnswer();
                    $newAnswer->id_attempt_quiz = $data['id_attempt_quiz'];
                    $newAnswer->id_question = $questionId;
                    $newAnswer->user_answer = $answer; // Pastikan data yang disimpan adalah string, bukan array
                    $newAnswer->is_correct = 0;
                    $newAnswer->save();
                }
            } else {
                // Jika sudah ada, lakukan perubahan
                foreach ($existingAnswer as $ea) {
                    // Jika ada jawaban baru untuk pertanyaan ini
                    if (isset($userAnswer[$ea->id_question])) {
                        $ea->user_answer = $userAnswer[$ea->id_question];
                        // $ea->is_correct = $this->checkAnswer($ea->id_question, $userAnswer[$ea->id_question]);
                        $ea->is_correct = 0;
                        $ea->save();
                    }
                }
            }
        }

        return response()->json(['success' => true]);
    }
    public function submitQuiz(Request $request, $id_quiz)
    {
        return "Coming Soon";
    }
}
