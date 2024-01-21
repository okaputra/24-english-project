<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tb_sub_courses as Sub;

class tb_courses extends Model
{
    use HasFactory;
    protected $table='tb_courses';

    protected $guarded = ['id'];

    public function subCourses(){
        return $this->hasMany(Sub::class, 'id_course');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($course) {
            // Hapus semua sub_courses terkait
            $course->subCourses()->delete();
        });
    }
}
