<?php

namespace App\Http\Controllers;
use App\Models\tb_courses as Course;
use App\Models\tb_sub_courses as Sub;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $courses = Course::orderBy('created_at', 'asc')->get();
        return view('main.main',[
            'courses'=>$courses,
        ]);
    }
    public function about(){
        return view('main.about');
    }
    public function courses(){
        return view('main.courses');
    }
    public function detailCourses($id){
        $detailCourse = Course::find($id);
        return view('main.detail-courses',[
            'detailCourse' => $detailCourse,
        ]);
    }
}
