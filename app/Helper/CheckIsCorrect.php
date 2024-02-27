<?php
namespace App\Helper;

use App\Models\tb_opsi as Opsi;

class CheckIsCorrect{

    public static function CheckIsCorrectAnswer($questionId, $userAnswer){
        $correctAnswer = Opsi::where('id', $userAnswer)
            ->where('id_soal', $questionId) // Filter by question ID
            ->where('is_jawaban_benar', 1)
            ->exists();

        return $correctAnswer ? 1 : 0;
    }

}
