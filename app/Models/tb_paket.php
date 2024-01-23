<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tb_paket_terpilih as Paket_Terpilih;

class tb_paket extends Model
{
    use HasFactory;
    protected $table='tb_pakets';

    protected $guarded = ['id'];

    public function paketTerpilih(){
        return $this->belongsTo(Paket_Terpilih::class, 'id_paket');
    }
}
