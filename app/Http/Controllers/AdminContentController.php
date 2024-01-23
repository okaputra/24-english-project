<?php

namespace App\Http\Controllers;
use App\Models\tb_soal as Soal;
use App\Models\tb_opsi as Opsi;

use Illuminate\Http\Request;

class AdminContentController extends Controller
{
    public function AddNewSubCourseContent(Request $req, $id){
        return view('admin.input-subcourse-content');
    }

    public function CreateSoal(){
        return view('admin.create-soal');
    }

    public function PostCreateSoal(Request $req){
        $req->validate([
            "pertanyaan" => 'required',
            "opsi.*" => 'required',
            'jawaban_benar' => 'required|array|size:1', // Hanya boleh satu jawaban benar
            'jawaban_benar.*' => 'integer',
        ]);
    
        // Simpan pertanyaan
        $soal = Soal::create([
            'pertanyaan' => $req->pertanyaan,
        ]);
        
        // Simpan opsi
        foreach ($req->input('opsi') as $key => $io) {
            $isJawabanBenar = $req->has('jawaban_benar') && in_array($key, $req->input('jawaban_benar'));
    
            Opsi::create([
                'opsi' => $io,
                'is_jawaban_benar' => $isJawabanBenar,
                'id_soal' => $soal->id,
            ]);
        }
    
        return redirect('/admin-create-soal')->with('success', "Submitted Successfully!");
    }
}
