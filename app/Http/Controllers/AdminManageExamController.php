<?php

namespace App\Http\Controllers;

use App\Models\tb_final_exam as Exam;
use App\Models\tb_paket as Paket;
use Illuminate\Http\Request;

class AdminManageExamController extends Controller
{
    public function AdminCreateExam($id_sub_course)
    {
        $paket = Paket::all();
        $exam = Exam::where('id_sub_course', $id_sub_course)->get();
        return view('admin.input-exam', [
            'paket' => $paket,
            'id_sub_course' => $id_sub_course,
            'exam'=>$exam
        ]);
    }
    public function AdminPostExam(Request $request, $id_sub_course)
    {
        $request->validate([
            "id_paket" => 'required',
            "durasi" => 'required',
        ]);
        Exam::create([
            'id_paket' => $request->id_paket,
            'id_sub_course' => $id_sub_course,
            'durasi' => $request->durasi,
        ]);
        return redirect()->back()->with('success', "Exam Submitted Succesfully!");
    }
    public function AdminUpdateExam($id)
    {
        $exam = Exam::find($id);
        $paket = Paket::all();
        $paket_terpilih = Paket::where('id', $exam->id_paket)->first();
        return view('admin.update-exam', [
            'exam' => $exam,
            'paket' => $paket,
            'paket_terpilih' => $paket_terpilih,
        ]);
    }
    public function AdminPostUpdateExam(Request $request, $id)
    {
        $request->validate([
            "id_paket" => 'required',
            "durasi" => 'required',
        ]);
        $exam = Exam::find($id);
        $exam->update([
            'id_paket' => $request->id_paket,
            'durasi' => $request->durasi,
        ]);

        return redirect("/admin-assign-exam/$exam->id_sub_course")->with('success', "Exam Updated Succesfully!");
    }
    public function AdminDeleteExam($id)
    {
        $exam = Exam::find($id);
        $exam->delete();
        return redirect()->back()->with('success', "Exam Deleted Succesfully!");
    }
}
