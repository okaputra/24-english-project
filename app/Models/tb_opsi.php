<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tb_soal as Soal;

class tb_opsi extends Model
{
    use HasFactory;
    protected $table='tb_opsis';

    protected $guarded = ['id'];

    public function soal(){
        return $this->belongsTo(Soal::class, 'id_soal');
    }
}
