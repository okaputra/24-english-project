<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_user_answer_exam extends Model
{
    use HasFactory;
    protected $table = 'tb_user_answer_exams';

    protected $guarded = ['id'];
}
