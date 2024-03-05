<?php

namespace App\Http\Controllers;

use App\Models\tb_courses as Course;
use App\Models\tb_sub_courses as Sub;
use App\Models\tb_users as User;
use App\Models\tb_user_purchase as UserPurchase;
use Illuminate\Http\Request;
use File;

class AdminController extends Controller
{
    public function index()
    {
        $countCourse = Course::all()->count();
        $countUser = User::all()->count();
        $countUserPurchase = UserPurchase::where('is_sudah_bayar', 'Paid')->count();
        $countUserUnpaid = UserPurchase::where('is_sudah_bayar', 'Unpaid')->count();
        return view('admin.dashboard', [
            'countCourse' => $countCourse,
            'countUser' => $countUser,
            'countUserPurchase' => $countUserPurchase,
            'countUserUnpaid' => $countUserUnpaid,
        ]);
    }

    public function indexCourse()
    {
        $courses = Course::orderBy('created_at', 'desc')->get();
        return view('admin.get-course', [
            'courses' => $courses
        ]);
    }

    public function inputCourse()
    {
        return view('admin.form-input-course');
    }

    public function postCourse(Request $req)
    {
        $req->validate([
            "course_name" => 'required',
            "description" => 'required',
            "components.*" => 'required',
            "thumbnail" => 'required|image|max:2048|mimes:jpg,jpeg,png'
        ]);

        if (!$req->hasFile('thumbnail')) {
            return redirect()->back()->with('error', "File Not Found!");
        }
        $courseThumbnail = $req->file('thumbnail');
        $filename = date('YmdHis') . "." . $courseThumbnail->getClientOriginalExtension();
        $path = public_path() . '/images/course-thumbnail/' . $filename;
        if (!File::isDirectory($path))
            File::makeDirectory($path, 0755, true);
        $combinedInput = implode('|', $req->input('components'));
        $course = Course::create([
            'course_name' => $req->course_name,
            'description' => $req->description,
            'components' => $combinedInput,
            'thumbnail' => $filename,
        ]);
        $courseId = $course->id;
        $courseThumbnail->move($path, $filename);
        $inputCom = $req->input('components');
        foreach ($inputCom as $ic) {
            Sub::create([
                'sub_course' => $ic,
                'id_course' => $courseId,
            ]);
        }
        return redirect('/admin-get-all-course')->with('success', "New Course Submitted Succesfully!");
    }

    public function detailCourse($id)
    {
        $detailCourse = Course::find($id);
        $sub_course = Sub::getSubCourseByIdCourse($id);
        $dataSub = $sub_course->data;
        return view('admin.detail-course', [
            'detail' => $detailCourse,
            'sub_course' => $dataSub
        ]);
    }

    public function deleteSubCourse($id)
    {
        $dataSubCourse = Sub::find($id);
        $course = Course::find($dataSubCourse->id_course);

        $dataSubCourse->delete();

        // Setelah perubahan, ambil semua sub_courses yang terkait dengan course ini
        $subCourses = $course->subCourses()->get()->pluck('sub_course')->toArray();

        // Gabungkan kembali sub_courses untuk update nilai components
        $combinedInput = implode('|', $subCourses);

        // Update nilai components pada model Course
        $course->update(['components' => $combinedInput]);
        return redirect()->back()->with('success', "Sub Course Deleted Succesfully!");
    }

    public function deleteCourse($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return redirect()->back()->with('error', "Course not found!");
        }
        // Panggil metode delete untuk memicu event deleting
        $course->delete();
        return redirect()->back()->with('success', "Course and related SubCourses deleted successfully!");
    }

    public function UpdateCourse($id)
    {
        $detailCourse = Course::find($id);
        return view('admin.edit-course', [
            'detail' => $detailCourse
        ]);
    }

    public function UpdateSubCourse($id, $id_course)
    {
        $detailSubCourse = Sub::find($id);
        return view('admin.edit-sub-course', [
            'detail' => $detailSubCourse,
            'id_course' => $id_course,
        ]);
    }

    public function PostUpdateSubCourse(Request $req, $id, $id_course)
    {
        $req->validate([
            "sub_course" => 'required',
            "pricing" => 'required',
        ]);

        $sub_course = Sub::find($id);
        $sub_course->update([
            'sub_course' => $req->sub_course,
            'pricing' => $req->pricing,
        ]);

        $course = Course::find($id_course);

        // Setelah perubahan, ambil semua sub_courses yang terkait dengan course ini
        $subCourses = $course->subCourses()->get()->pluck('sub_course')->toArray();

        // Gabungkan kembali sub_courses untuk update nilai components
        $combinedInput = implode('|', $subCourses);

        // Update nilai components pada model Course
        $course->update(['components' => $combinedInput]);
        return redirect("/admin-detail-course/$id_course")->with('success', "Sub Course Updated Succesfully!");

    }

    public function AddNewSubCourse($id)
    {
        $dataSubCourse = Sub::getSubCourseByIdCourse($id);
        $dataSub = $dataSubCourse->data;
        return view('admin.form-input-sub-course', [
            'id_course' => $id,
            'datasub' => $dataSub
        ]);
    }

    public function PostNewSubCourse(Request $req, $id)
    {
        $req->validate([
            "components.*" => 'required',
        ]);
        $inputCom = $req->input('components');

        // Perbarui nilai kolom untuk setiap Sub
        foreach ($inputCom as $ic) {
            Sub::create([
                'sub_course' => $ic,
                'id_course' => $id,
            ]);
        }

        $course = Course::find($id);

        // Setelah perubahan, ambil semua sub_courses yang terkait dengan course ini
        $subCourses = $course->subCourses()->get()->pluck('sub_course')->toArray();

        // Gabungkan kembali sub_courses untuk update nilai components
        $combinedInput = implode('|', $subCourses);

        // Update nilai components pada model Course
        $course->update(['components' => $combinedInput]);
        return redirect("/admin-detail-course/$id")->with('success', "Sub Course Added Succesfully!");
    }

    public function PostUpdateCourse(Request $req, $id)
    {
        // Temukan instance Course yang akan diperbarui
        $course = Course::find($id);

        // check if user upload new image
        if ($req->file('thumbnail')) {
            $courseThumbnail = $req->file('thumbnail');
            $filename = date('YmdHis') . "." . $courseThumbnail->getClientOriginalExtension();
            $path = public_path() . '/images/course-thumbnail/' . $filename;
            $courseThumbnail->move($path, $filename);
            $course->update([
                'thumbnail' => $filename,
            ]);
        }

        // Perbarui nilai kolom
        $course->update([
            'course_name' => $req->course_name,
            'description' => $req->description,
            // 'components' => $combinedInput
        ]);

        return redirect("/admin-detail-course/$id")->with('success', "Course Updated Succesfully!");
    }
    public function AdminInputEvaluasi($id_category)
    {
        $id = $id_category;
        return view('admin.input-evaluasi', [
            'id_category' => $id,
        ]);
    }
}