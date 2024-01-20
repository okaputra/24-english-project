<?php

namespace App\Http\Controllers;

use App\Models\tb_courses as Course;
use Illuminate\Http\Request;
use File;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function indexCourse(){
        $courses = Course::orderBy('created_at', 'desc')->get();
        return view('admin.get-course',[
            'courses' => $courses
        ]);
    }
    public function inputCourse(){
        return view('admin.form-input-course');
    }
    public function postCourse(Request $req){
        $req->validate([
            "course_name" => 'required',
            "description" => 'required',
            "pricing" => 'required',
            "components.*" => 'required',
            "thumbnail" => 'required|image|max:2048|mimes:jpg,jpeg,png'
        ]);

        if(!$req->hasFile('thumbnail')){
            return redirect()->back()->with('error', "File Not Found!");
        }
        $courseThumbnail = $req->file('thumbnail');
        $filename = date('YmdHis') . "." . $courseThumbnail->getClientOriginalExtension();
        $path = public_path() . '/images/course-thumbnail/'.$filename;
        if(!File::isDirectory($path))
        File::makeDirectory($path,0755,true);
        $combinedInput = implode('|', $req->input('components'));
        Course::create([
            'course_name'=>$req->course_name,
            'description'=>$req->description,
            'pricing'=>$req->pricing,
            'components'=>$combinedInput,
            'thumbnail'=>$filename,
        ]);
        $courseThumbnail->move($path, $filename);
        return redirect('/admin-input-course')->with('success', "New Course Submitted Succesfully!");
    }
}