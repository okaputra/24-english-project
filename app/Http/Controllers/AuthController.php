<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Helper\Validator\userValidator;
use App\Models\tb_users as User;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    // === User
    private function setSessionUser($user){
        $sessionData = [
            "login"=>true,
            "role"=>0,
            "id"=>$user->id,
            "first_name"=>$user->first_name,
            "last_name"=>$user->last_name,
            "email"=>$user->email,
            "user_photo"=>$user->user_photo,
        ];
        Session::put($sessionData);
    }

    //Support function
    private static function isAlreadyLogin(){
        if(Session::get("login")){
            return true;
        }
        return false;
    }

    public function index(){
        return view('auth.login');
    }

    public function loginPost(Request $req){
        $post=(object)$req->validate([
            "email"=>"required",
            "password"=>"required"
        ]);
        $result = User::loginProcess($post->email,$post->password);
        // dd($result);
        if($result->success){
            if($result->login){
                $this->setSessionUser($result->data);
                return redirect('/')->with('success',"Login success");
            }
            else{
                return redirect('/login-user')->with('error',"Email or Password Incorrect");
            }
        }return redirect('/login-user')->with('error',"Email not registered, Please Register First!");
    }

    public function register(){
        return view('auth.register');
    }

    public function registerUser(Request $req){
        $validatedInput = $req->validate(userValidator::getValidationRules());
        $user=User::registerUser($validatedInput);
        if($user->success){
            $user=$user->data;
            return redirect("/login-user")->with('success',"Registration Success");
        }else{
            return redirect('/register-user')->with('error','Registration Failed!');
        }
    }

    // === General
    public function logout(){
        Session::flush();
        return redirect("/");
    }
}
