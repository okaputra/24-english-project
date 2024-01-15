<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        return view('main.main');
    }
    public function about(){
        return view('main.about');
    }
    public function courses(){
        return view('main.courses');
    }
    public function detailCourses(){
        return view('main.detail-courses');
    }
}
