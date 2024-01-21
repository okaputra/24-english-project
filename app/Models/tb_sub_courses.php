<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tb_courses as Course;

class tb_sub_courses extends Model
{
    use HasFactory;
    protected $table='tb_sub_courses';

    protected $guarded = ['id'];

    public static function getSubCourseByIdCourse($idCourse){
        $data = self::where("id_course",$idCourse)->get();
        if($data){
            return (object)[
                "success"=>true,
                "data"=>$data
            ];
        }
        return (object)[
            "success"=>false,
            "message"=>"Gagal menemukan sub course"
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }
}
