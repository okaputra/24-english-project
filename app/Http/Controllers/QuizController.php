<?php

namespace App\Http\Controllers;

use App\Models\tb_quiz as Quiz;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use App\Models\tb_soal as Soal;
use App\Models\tb_user_attempt_quiz as UserAttemptQuiz;
use App\Models\tb_user_answer as UserAnswer;
use App\Helper\CheckIsCorrect;
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

        $currentQuiz = UserAttemptQuiz::where('id_quiz', $id_quiz)->where('id_user', Session::get('id'))->first();
        if ($currentQuiz == null) {
            $attemptQuiz = new UserAttemptQuiz();
            $attemptQuiz->id_user = Session::get('id');
            $attemptQuiz->id_quiz = $id_quiz;
            $attemptQuiz->start = Carbon::now();
            $attemptQuiz->save();
            $userAnswers = UserAnswer::where('id_attempt_quiz', $attemptQuiz->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswer::where('id_attempt_quiz', $attemptQuiz->id)->whereRaw("user_answer NOT REGEXP '^[0-9]+$'")->get();
            return view('main.start-quiz', [
                'quiz' => $quiz,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentQuiz' => $attemptQuiz,
                'user_answers' => $userAnswers,
                'user_answers_desc' => $userAnswersDesc,
                'id_sub_course' => $id_sub_course
            ]);
        } elseif ($currentQuiz->end == null) {
            $userAnswers = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->whereRaw("user_answer NOT REGEXP '^[0-9]+$'")->get();
            return view('main.start-quiz', [
                'quiz' => $quiz,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentQuiz' => $currentQuiz,
                'user_answers' => $userAnswers,
                'user_answers_desc' => $userAnswersDesc,
                'id_sub_course' => $id_sub_course
            ]);
        }
        return redirect("/user-get-subcourse-material/$id_quiz/$id_sub_course")->with('info', 'Quiz Telah Selesai, Tekan Re-Attempt Quiz Untuk Memulai Kembali!');
    }
    public function RestartQuiz($id_quiz, $id_sub_course)
    {
        $userAttemptData = UserAttemptQuiz::where('id_quiz', $id_quiz)->where('id_user', Session::get('id'))->first();

        if ($userAttemptData == null) {
            return redirect()->back()->with('error', 'Quiz Tidak Ditemukan!');
        }
        UserAnswer::where('id_attempt_quiz', $userAttemptData->id)->delete();

        $userAttemptData->update([
            'end' => NULL
        ]);
        return redirect("/user-attempt-quiz/$id_quiz/$id_sub_course");
    }
    public function SimpanJawabanUser(Request $request)
    {
        $data = $request->all();

        foreach ($data['user_answers'] as $questionId => $userAnswer) {
            // Cek apakah data sudah ada
            $existingAnswer = UserAnswer::where('id_attempt_quiz', $data['id_attempt_quiz'])
                ->where('id_question', $questionId)
                ->first();

            if (!$existingAnswer) {
                foreach ($userAnswer as $index => $answer) {
                    $newAnswer = new UserAnswer();
                    $newAnswer->id_attempt_quiz = $data['id_attempt_quiz'];
                    $newAnswer->id_question = $questionId;
                    $newAnswer->user_answer = $answer;
                    $newAnswer->is_correct = CheckIsCorrect::CheckIsCorrectAnswer($questionId, $answer);
                    $newAnswer->save();
                }
            } else {
                // Jika ada jawaban baru untuk pertanyaan ini
                foreach ($userAnswer as $index => $answer) {
                    $existingAnswer->user_answer = $answer;
                    $existingAnswer->is_correct = CheckIsCorrect::CheckIsCorrectAnswer($questionId, $answer);
                    $existingAnswer->save();
                }
            }
        }

        return response()->json(['success' => true]);
    }
    public function submitQuiz(Request $request, $id_quiz, $id_sub_course)
    {
        $attemptQuiz = UserAttemptQuiz::find($request->id_attempt_quiz);
        $attemptQuiz->update([
            'end' => Carbon::now()
        ]);
        return redirect("/user-get-result-quiz/$id_quiz/$id_sub_course")->with('success', 'Quiz Submitted Succesfully!');
    }
    public function GetQuizResult($id_quiz, $id_sub_course)
    {
        $quiz = Quiz::find($id_quiz);
        $paket = Paket::find($quiz->id_paket);
        $soal_terpilih = PaketTerpilih::where('id_paket', $paket->id)->get();
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->simplePaginate(5);
        $soalAll = Soal::whereIn('id', $soal_terpilih_ids)->get();
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();

        $currentQuiz = UserAttemptQuiz::where('id_quiz', $id_quiz)->where('id_user', Session::get('id'))->first();
        if (!$currentQuiz) {
            return redirect("/user-get-subcourse-material/$id_quiz/$id_sub_course")->with('info', 'Not Found!');
        }
        if ($currentQuiz->end != null) {
            $userAnswers = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->whereRaw("user_answer NOT REGEXP '^[0-9]+$'")->get();
            $correctAnswer = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->whereRaw("user_answer REGEXP '^[0-9]+$'")->where('is_correct', 1)->count();
            $wrongAnswer = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->whereRaw("user_answer REGEXP '^[0-9]+$'")->where('is_correct', 0)->count();
            $showClue = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->whereRaw("user_answer REGEXP '^[0-9]+$'")->where('is_correct', 0)->pluck('id_question');
            $showClueifBlank = UserAnswer::where('id_attempt_quiz', $currentQuiz->id)->whereRaw("user_answer REGEXP '^[0-9]+$'")->pluck('id_question');

            $isShowClue = [];
            $blankAnswer = [];
            foreach ($soalAll as $q) {
                // Determine if the clue should be shown for this question
                $isShowClue[$q->id] = $showClue->contains($q->id);
                $blankAnswer[$q->id] = !$showClueifBlank->contains($q->id);
            }

            // Count Blank Answer
            $blankAnswerCount = 0;
            foreach ($blankAnswer as $questionId => $isBlank) {
                // Assuming $questions is a collection of all questions with their details
                $questionType = $soalAll->where('id', $questionId)->pluck('tipe')->first();

                // Check if the question type is "opsi" and the answer is blank
                if ($questionType === 'opsi' && $isBlank) {
                    $blankAnswerCount++;
                }
            }
            return view('main.result-quiz', [
                'quiz' => $quiz,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentQuiz' => $currentQuiz,
                'user_answers' => $userAnswers,
                'user_answers_desc' => $userAnswersDesc,
                'correctAnswer' => $correctAnswer,
                'wrongAnswer' => $wrongAnswer,
                'isShowClue' => $isShowClue,
                'blankAnswer' => $blankAnswer,
                'blankAnswerCount' => $blankAnswerCount,
                'id_sub_course' => $id_sub_course
            ]);
        }
        return redirect("/user-get-subcourse-material/$id_quiz/$id_sub_course")->with('info', 'Not Found!');
    }
}
