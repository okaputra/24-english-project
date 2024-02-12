<?php

namespace App\Http\Controllers;

use App\Models\tb_courses as Course;
use App\Models\tb_sub_courses as Sub;
use App\Models\tb_quiz as Quiz;
use App\Models\tb_user_purchase as UserPurchase;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use Session;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('created_at', 'asc')->get();
        return view('main.main', [
            'courses' => $courses,
        ]);
    }
    public function about()
    {
        return view('main.about');
    }
    public function courses()
    {
        return view('main.courses');
    }
    public function detailCourses($id)
    {
        $detailCourse = Course::find($id);
        $subCourses = $detailCourse->subCourses;
        return view('main.detail-courses', [
            'detailCourse' => $detailCourse,
            'subCourses' => $subCourses
        ]);
    }
    public function detailSubCourse($id)
    {
        $userId = Session::get('id');
        $userPurchase = UserPurchase::where('id_user', $userId)
            ->where('id_sub_terbayar', $id)
            ->where('is_sudah_bayar', 1)
            ->first();
        $subCourse = Sub::find($id);
        $quiz = $subCourse->Quiz;
        $userPaidThisSubCourse = UserPurchase::where('id_sub_terbayar', $id)->count();
        return view('main.detail-subcourse', [
            'subCourse' => $subCourse,
            'quiz' => $quiz,
            'userPurchase' => $userPurchase,
            'userPaidThisSubCourse' => $userPaidThisSubCourse
        ]);
    }
    public function getSubCourseContent($id_quiz, $id_sub_course)
    {
        $quiz = Quiz::find($id_quiz);
        $paket = Paket::find($quiz->id_paket);
        $jumlah_soal = PaketTerpilih::where('id_paket', $paket->id)->count();
        return view('main.category-content', [
            'quiz' => $quiz,
            'jumlah_soal' => $jumlah_soal,
        ]);
    }
    public function rateSubCourseContent(Request $req, $id_sub_course)
    {
        $req->validate(['rate' => 'required']);
        $subCourse = Sub::find($id_sub_course);
        $rating = new \willvincent\Rateable\Rating;
        $rating->rating = $req->rate;
        $rating->user_id = Session::get('id');
        $rating->id_sub_course = $id_sub_course;
        Sub::where('id', $id_sub_course)->update([
            'rating' => $req->rate,
            'number_of_review' => $subCourse->usersRated(),
        ]);
        $subCourse->ratings()->save($rating);
        return redirect()->back()->with('success', 'Rating Send Successfully!');
    }
}
