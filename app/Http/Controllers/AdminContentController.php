<?php

namespace App\Http\Controllers;

use App\Models\tb_soal as Soal;
use App\Models\tb_opsi as Opsi;
use App\Models\tb_paket as Paket;
use App\Models\tb_paket_terpilih as PaketTerpilih;

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
            $isJawabanBenar = $req->input('jawaban_benar')[0] == $key;

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

    // Paket 

    public function CreatePaket()
    {
        $paket = Paket::all();
        return view('admin.create-paket', [
            'paket' => $paket
        ]);
    }

    public function PostCreatePaket(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required'
        ]);
        Paket::create([
            'nama_paket' => $request->nama_paket
        ]);
        return redirect()->back()->with('success', 'Submitted Successfully!');
    }

    public function DeletePaket($id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return redirect()->back()->with('error', "Paket not found!");
        }
        PaketTerpilih::where('id_paket', $paket->id)->delete();
        $paket->delete();

        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function UpdatePaket($id)
    {
        $paket = Paket::find($id);
        $soal_terpilih = PaketTerpilih::where('id_paket', $id)->get();
        // Ambil data soal terpilih sebagai array
        $soal_terpilih_ids = $soal_terpilih->pluck('id_soal')->toArray();
        $soal_all = Soal::all();
        // Ambil semua soal terkait
        $soal = Soal::whereIn('id', $soal_terpilih_ids)->get();
        return view('admin.update-paket', [
            'paket' => $paket,
            'soal_terpilih_ids' => $soal_terpilih_ids,
            'soal' => $soal,
            'soal_all' => $soal_all,
        ]);
    }

    public function PostUpdatePaket(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_paket' => 'required',
            'soal' => 'array', // Pastikan 'soal' adalah array
        ]);

        // Temukan paket
        $paket = Paket::find($id);

        // Periksa apakah paket ditemukan
        if (!$paket) {
            return redirect()->back()->with('error', 'Paket not found!');
        }

        // Update nama paket
        $paket->update([
            'nama_paket' => $request->nama_paket,
        ]);

        // Ambil id soal terpilih yang saat ini ada pada paket
        $soal_terpilih_ids = PaketTerpilih::where('id_paket', $id)->get()->pluck('id_soal')->toArray();

        // Ambil id soal yang dikirimkan melalui form
        $input_soal_ids = $request->input('soal', []);

        // Hitung perbedaan id soal yang terpilih saat ini dan yang dikirimkan melalui form
        $soal_ids_to_add = array_diff($input_soal_ids, $soal_terpilih_ids);
        $soal_ids_to_remove = array_diff($soal_terpilih_ids, $input_soal_ids);

        // Tambahkan soal baru yang dipilih
        foreach ($soal_ids_to_add as $soal_id) {
            PaketTerpilih::create([
                'id_paket' => $paket->id,
                'id_soal' => $soal_id,
            ]);
        }

        // Hapus soal yang tidak dipilih lagi
        PaketTerpilih::where('id_paket', $id)->whereIn('id_soal', $soal_ids_to_remove)->delete();

        return redirect()->back()->with('success', 'Updated Successfully!');

    }

    public function AssignPaket($id)
    {
        $soal = Soal::all();
        $paket = Paket::find($id);

        return view('admin.assign-paket', [
            'soal' => $soal,
            'paket' => $paket,
        ]);
    }

    public function PostAssignPaket(Request $request, $id_paket)
    {
        $request->validate([
            'soal' => 'required|array',
            'soal.*' => 'integer',
        ]);

        foreach ($request->input('soal') as $id_soal) {
            PaketTerpilih::create([
                'id_paket' => $id_paket,
                'id_soal' => $id_soal,
            ]);
        }

        return redirect('/admin-create-paket')->with('success', 'Soal berhasil di-assign ke paket.');
    }
}
