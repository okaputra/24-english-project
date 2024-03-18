<?php
namespace App\Helper;

use App\Models\tb_opsi as Opsi;
use App\Models\tb_soal as Soal;

class CheckIsCorrect
{

    public static function CheckIsCorrectAnswer($questionId, $userAnswer)
    {
        $correctAnswerOption = Opsi::where('id', $userAnswer)
            ->where('id_soal', $questionId) // Filter by question ID
            ->where('is_jawaban_benar', 1)
            ->exists();

        // Check for description type question
        $correctAnswerDescription = Soal::where('id', $questionId)
            ->whereRaw("FIND_IN_SET('$userAnswer', kunci_jawaban_deskripsi)")
            ->exists();

        // If either option or description type answer is correct, return 1
        if ($correctAnswerOption || $correctAnswerDescription) {
            return 1;
        } else {
            return 0;
        }
    }

}
