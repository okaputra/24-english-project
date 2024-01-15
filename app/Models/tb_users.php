<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class tb_users extends Model
{
    use HasFactory;

    //
    protected $table = "tb_users";
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "password",
        "user_photo",
    ];

    public static function getUserById($idUser){
        $user = self::where("id",$idUser)->get();
        if($user){return (object)["success"=>true,"data"=>$user];}
        return (object)["success"=>false,"message"=>"failed!"];
    }

    private static function checkEmail($email) {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }

    public static function isExist($emailOrUsername){
        //check is email or username
        $user=false;
        if(self::checkEmail($emailOrUsername))
            $user=self::where('email', $emailOrUsername)->first();
        else
            $user=self::where('first_name',$emailOrUsername)->first();

        return (object)[
            "success"=>true,
            "exist"=>$user?true:false,
            "data"=>$user
        ];
    }

    public static function loginProcess($email,$password){
        $user=self::isExist($email);
        if($user->exist){
            $isPasswordCorrect = Hash::check($password, $user->data->password);
            if($isPasswordCorrect)
                return (object)[
                    "success"=>true,
                    "login"=>true,
                    "data"=>$user->data
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

    public static function registerUser($validatedSubmitedData){
        $data=$validatedSubmitedData;
        $data["password"]=Hash::make($data["password"]);
        $user=self::create($data);
        if($user){
            return(object)[
                "success"=>true,
                "data"=>$user
            ];
        }
        return(object)[
            "success"=>false,
            "data"=>null,
            "message"=>"Register failed"
        ];
    }
}
