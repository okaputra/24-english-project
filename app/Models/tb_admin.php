<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class tb_admin extends Model
{
    use HasFactory;
    protected $table='tb_admin';

    protected $guarded = ['id'];

    public static function isExist($username){
        $admin=false;
        $admin=self::where('username',$username)->first();
        return (object)[
            "success"=>true,
            "exist"=>$admin?true:false,
            "data"=>$admin
        ];
    }

    public static function loginAdminProcess($username,$password){
        $admin=self::isExist($username);
        if($admin->exist){
            $isPasswordCorrect = Hash::check($password, $admin->data->password);
            if($isPasswordCorrect)
                return (object)[
                    "success"=>true,
                    "login"=>true,
                    "data"=>$admin->data
                ];
            else
                return (object)[
                    "success"=>true,
                    "login"=>false,
                    "message"=>"Incorrect password"
                ];
        }else{
            return (object)[
                "success"=>false,
                "login"=>false,
                "message"=>"Username or Email not registered"
            ];
        }
    }

    public static function akses($username){
        $akun=self::where('username', $username)->first();
        // dd($akun);
        return $akun->akses;
    }
    
}
