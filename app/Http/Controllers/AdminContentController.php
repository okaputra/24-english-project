<?php

namespace App\Http\Controllers;

use App\Models\tb_soal as Soal;
use App\Models\tb_opsi as Opsi;

use Illuminate\Http\Request;

class AdminContentController extends Controller
{
    public function AddNewSubCourseContent(Request $req, $id)
    {
        return view('admin.input-subcourse-content');
    }

    public function CreateSoal()
    {
        $dataSoal = Soal::all();
        return view('admin.create-soal', [
            'dataSoal' => $dataSoal,
        ]);
    }

    public function PostCreateSoal(Request $req)
    {
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

    public function DeleteSoal($id)
    {
        $soal = Soal::find($id);
        if (!$soal) {
            return redirect()->back()->with('error', "Soal not found!");
        }
        // Panggil metode delete untuk memicu event deleting
        $soal->delete();
        return redirect()->back()->with('success', "Soal and related Opsi deleted successfully!");
    }

    public function UpdateSoal($id)
    {
        $soal = Soal::find($id);
        $opsi = $soal->opsi()->get()->toArray();
        $jawabanBenar = array_filter($opsi, function ($opsi) {
            return $opsi['is_jawaban_benar'] == 1;
        });
        return view('admin.update-soal', [
            'soal' => $soal,
            'opsi' => $opsi,
            'jawaban_benar' => $jawabanBenar,
        ]);
    }

    public function PostUpdateSoal(Request $req, $id)
    {
        $req->validate([
            "pertanyaan" => 'required',
            "opsi.*" => 'required',
            'jawaban_benar' => 'required|array|size:1', // Hanya boleh satu jawaban benar
            'jawaban_benar.*' => 'integer',
        ]);
        
        $soal = Soal::find($id);
        $soal->update([
            'pertanyaan' => $req->pertanyaan,
        ]);
        
        // Hapus opsi lama sebelum menambahkan yang baru
        $soal->opsi()->delete();
        
        // Simpan opsi baru
        foreach ($req->input('opsi') as $key => $io) {
            $isJawabanBenar = $req->has('jawaban_benar') && in_array($key, $req->input('jawaban_benar'));
        
            $soal->opsi()->create([
                'opsi' => $io,
                'is_jawaban_benar' => $isJawabanBenar,
            ]);
        }

        return redirect('/admin-create-soal')->with('success', "Submitted Successfully!");
    }

    public function DeleteOpsi($id)
    {
        $opsi = Opsi::find($id);
        if (!$opsi) {
            return redirect()->back()->with('error', "Opsi not found!");
        }
        $opsi->delete();
        return redirect()->back()->with('success', "Opsi deleted successfully!");
    }
}
