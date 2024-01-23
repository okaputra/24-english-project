<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tb_sub_courses as Sub;

class tb_quiz extends Model
{
    use HasFactory;
    protected $table='tb_quiz';

    protected $guarded = ['id'];

    public function subCourses(){
        return $this->belongsTo(Sub::class, 'id_sub_course');
    }

}
