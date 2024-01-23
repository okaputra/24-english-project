<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tb_opsi as Opsi;
use App\Models\tb_paket_terpilih as Paket_Terpilih;

class tb_soal extends Model
{
    use HasFactory;
    protected $table='tb_soal';

    protected $guarded = ['id'];

    public function opsi(){
        return $this->hasMany(Opsi::class, 'id_soal');
    }

    public function paketTerpilih(){
        return $this->belongsTo(Paket_Terpilih::class, 'id_soal');
    }
}
