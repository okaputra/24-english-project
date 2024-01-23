<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tb_paket as Paket;
use App\Models\tb_soal as Soal;

class tb_paket_terpilih extends Model
{
    use HasFactory;
    protected $table='tb_paket_terpilihs';

    protected $guarded = ['id'];

    public function paket(){
        return $this->hasMany(Paket::class, 'id_paket');
    }
    public function soal(){
        return $this->hasMany(Soal::class, 'id_soal');
    }
}
