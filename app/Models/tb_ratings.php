<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_ratings extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $guarded = ['id'];
    protected $fillable = ['rating', 'user_id', 'id_sub_course'];

    public function subCourse()
    {
        return $this->belongsTo('App\tb_sub_course', "id_sub_course");
    }

}
