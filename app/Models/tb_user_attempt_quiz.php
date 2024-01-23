<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_user_attempt_quiz extends Model
{
    use HasFactory;
    protected $table='tb_user_attempt_quizzes';

    protected $guarded = ['id'];
}
