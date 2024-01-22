<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminContentController extends Controller
{
    public function AddNewSubCourseContent(Request $req, $id){
        return view('admin.input-subcourse-content');
    }
}
