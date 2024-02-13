<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_user_purchase extends Model
{
    use HasFactory;
    protected $table = 'tb_user_purchases';
    protected $guarded = ['id'];
}
