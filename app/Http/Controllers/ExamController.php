<?php

namespace App\Http\Controllers;

use App\Models\tb_final_exam as Exam;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use App\Models\tb_soal as Soal;
use App\Models\tb_user_attempt_exam as UserAttemptExam;
use App\Models\tb_user_answer_exam as UserAnswerExam;
use App\Helper\CheckIsCorrect;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function StartExam($id_exam, $id_sub_course)
    {
        $exam = Exam::find($id_exam);
        if ($exam->id_paket == NULL) {
            return redirect("/detail-my-subcourse/$id_sub_course")->with('info', 'Exam Not Found!');
        }
        $paket = Paket::find($exam->id_paket);
        $soal_terpilih = PaketTerpilih::where('id_paket', $paket->id)->get();
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->simplePaginate(5);
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();

        $currentExam = UserAttemptExam::where('id_exam', $id_exam)->where('id_user', Session::get('id'))->first();
        if ($currentExam == null) {
            $attemptExam = new UserAttemptExam();
            $attemptExam->id_user = Session::get('id');
            $attemptExam->id_exam = $id_exam;
            $attemptExam->start = Carbon::now();
            $attemptExam->save();
            $userAnswers = UserAnswerExam::where('id_attempt_exam', $attemptExam->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswerExam::where('id_attempt_exam', $attemptExam->id)->get();
            return view('main.start-exam', [
                'exam' => $exam,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentExam' => $attemptExam,
                'user_answers' => $userAnswers,
                'user_answers_desc' => $userAnswersDesc,
                'id_sub_course' => $id_sub_course,
            ]);
        } elseif ($currentExam->end == null) {
            $userAnswers = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->get();
            return view('main.start-exam', [
                'exam' => $exam,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentExam' => $currentExam,
                'user_answers' => $userAnswers,
                'user_answers_desc' => $userAnswersDesc,
                'id_sub_course' => $id_sub_course,
            ]);
        }
        return redirect("/detail-my-subcourse/$id_sub_course")->with('info', 'Exam Telah Selesai!');
    }
    public function SaveAnswer(Request $request)
    {
        $data = $request->all();

        foreach ($data['user_answers'] as $questionId => $userAnswer) {
            // Cek apakah data sudah ada
            $existingAnswer = UserAnswerExam::where('id_attempt_exam', $data['id_attempt_exam'])
                ->where('id_question', $questionId)
                ->first();

            if (!$existingAnswer) {
                foreach ($userAnswer as $index => $answer) {
                    $newAnswer = new UserAnswerExam();
                    $newAnswer->id_attempt_exam = $data['id_attempt_exam'];
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
    public function SubmitExam(Request $request, $id_exam, $id_sub_course)
    {
        $attemptExam = UserAttemptExam::find($request->id_attempt_exam);
        $attemptExam->update([
            'end' => Carbon::now()
        ]);
        return redirect("/user-get-exam/$id_exam/$id_sub_course")->with('success', 'Exam Submitted Succesfully!');
    }
    public function GetResultExam($id_exam, $id_sub_course)
    {
        $exam = Exam::find($id_exam);
        if ($exam->id_paket == NULL) {
            return redirect("/user-get-exam/$id_exam/$id_sub_course")->with('info', 'Exam Not Found!');
        }
        $paket = Paket::find($exam->id_paket);
        $soal_terpilih = PaketTerpilih::where('id_paket', $paket->id)->get();
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->simplePaginate(5);
        $soalAll = Soal::whereIn('id', $soal_terpilih_ids)->get();
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();

        $currentExam = UserAttemptExam::where('id_exam', $id_exam)->where('id_user', Session::get('id'))->first();
        if (!$currentExam) {
            return redirect("/user-get-exam/$id_exam/$id_sub_course")->with('info', 'Not Found!');
        }
        if ($currentExam->end != null) {
            $userAnswers = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->pluck('user_answer', 'id_question')->toArray();
            $userAnswersDesc = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->get();
            $correctAnswer = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->where('is_correct', 1)->count();
            $wrongAnswer = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->where('is_correct', 0)->count();
            $showClue = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->where('is_correct', 0)->pluck('id_question');
            $showClueifBlank = UserAnswerExam::where('id_attempt_exam', $currentExam->id)->pluck('id_question');

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
                // Check if the question is blank
                if ($isBlank) {
                    $blankAnswerCount++;
                }
            }
            return view('main.result-exam', [
                'exam' => $exam,
                'soal' => $soal,
                'jumlah_soal' => $jumlah_soal,
                'currentExam' => $currentExam,
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
        return redirect("/user-get-exam/$id_exam/$id_sub_course")->with('info', 'Not Found!');
    }
}
