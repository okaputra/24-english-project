<?php

namespace App\Http\Controllers;

use App\Models\tb_tryout as Tryout;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use App\Models\tb_soal as Soal;
use App\Models\tb_user_attempt_tryout as UserAttemptTryout;
use App\Models\tb_user_answer_tryout as UserAnswerTryout;
use App\Helper\CheckIsCorrect;
use Session;
use Carbon\Carbon;

use Illuminate\Http\Request;

class TryoutController extends Controller
{
    public function StartTryout($id_tryout, $id_sub_course)
    {
        $tryout = Tryout::find($id_tryout);
        if ($tryout->id_paket == NULL) {
            return redirect("/detail-my-subcourse/$id_sub_course")->with('info', 'Tryout Not Found!');
        }
        $paket = Paket::find($tryout->id_paket);
        $soal_terpilih = PaketTerpilih::where('id_paket', $paket->id)->get();
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->simplePaginate(5);
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();
        $allowedReattempt = 3 - $tryout->count_attempt;

        $currentTryout = UserAttemptTryout::where('id_tryout', $id_tryout)->where('id_user', Session::get('id'))->first();
        if ($currentTryout == null) {
            $attemptTryout = new UserAttemptTryout();
            $attemptTryout->id_user = Session::get('id');
            $attemptTryout->id_tryout = $id_tryout;
            $attemptTryout->start = Carbon::now();
            $attemptTryout->save();
            $userAnswers = UserAnswerTryout::where('id_attempt_tryout', $attemptTryout->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswerTryout::where('id_attempt_tryout', $attemptTryout->id)->whereRaw("user_answer NOT REGEXP '^[0-9]+$'")->get();
            return view('main.start-tryout', [
                'tryout' => $tryout,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentTryout' => $attemptTryout,
                'user_answers' => $userAnswers,
                'user_answers_desc' => $userAnswersDesc,
                'id_sub_course' => $id_sub_course,
                'allowedReattempt' => $allowedReattempt,
            ]);
        } elseif ($currentTryout->end == null) {
            $userAnswers = UserAnswerTryout::where('id_attempt_tryout', $currentTryout->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswerTryout::where('id_attempt_tryout', $currentTryout->id)->whereRaw("user_answer NOT REGEXP '^[0-9]+$'")->get();
            return view('main.start-tryout', [
                'tryout' => $tryout,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentTryout' => $currentTryout,
                'user_answers' => $userAnswers,
                'user_answers_desc' => $userAnswersDesc,
                'id_sub_course' => $id_sub_course,
                'allowedReattempt' => $allowedReattempt,
            ]);
        }
        return redirect("/detail-my-subcourse/$id_sub_course")->with('info', 'Tryout Telah Selesai, Tekan Re-Attempt Tryout Untuk Memulai Kembali!');
    }
    public function RestartTryout($id_tryout, $id_sub_course)
    {
        $userAttemptData = UserAttemptTryout::where('id_tryout', $id_tryout)->where('id_user', Session::get('id'))->first();
        $tryout = Tryout::find($id_tryout);

        if ($userAttemptData == null) {
            return redirect()->back()->with('error', 'Tryout Tidak Ditemukan!');
        }
        if ($tryout->count_attempt < 3) {
            UserAnswerTryout::where('id_attempt_tryout', $userAttemptData->id)->delete();
            $userAttemptData->update([
                'end' => NULL
            ]);
            $tryout->update([
                'count_attempt' => $tryout->count_attempt + 1
            ]);
            return redirect("/user-attempt-tryout/$id_tryout/$id_sub_course");
        } else {
            return redirect("/user-get-tryout/$id_tryout/$id_sub_course")->with('info', 'Anda Hanya Boleh Re-attempt Sebanyak 3 Kali!');
        }
    }
    public function SaveAnswer(Request $request)
    {
        $data = $request->all();

        foreach ($data['user_answers'] as $questionId => $userAnswer) {
            // Cek apakah data sudah ada
            $existingAnswer = UserAnswerTryout::where('id_attempt_tryout', $data['id_attempt_tryout'])
                ->where('id_question', $questionId)
                ->first();

            if (!$existingAnswer) {
                foreach ($userAnswer as $index => $answer) {
                    $newAnswer = new UserAnswerTryout();
                    $newAnswer->id_attempt_tryout = $data['id_attempt_tryout'];
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
    public function SubmitTryout(Request $request, $id_tryout, $id_sub_course)
    {
        $attemptTryout = UserAttemptTryout::find($request->id_attempt_tryout);
        $attemptTryout->update([
            'end' => Carbon::now()
        ]);
        // return redirect("/user-get-result-tryout/$id_tryout/$id_sub_course")->with('success', 'Tryout Submitted Succesfully!');
        return redirect("/user-get-tryout/$id_tryout/$id_sub_course")->with('success', 'Tryout Submitted Succesfully!');
    }
    public function GetResultTryout()
    {

    }
}
