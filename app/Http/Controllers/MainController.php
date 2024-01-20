<?php

namespace App\Http\Controllers;
use App\Models\tb_courses as Course;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $courses = Course::orderBy('created_at', 'asc')->get();
        return view('main.main',[
            'courses'=>$courses
        ]);
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
