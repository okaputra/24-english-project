<?php

namespace App\Http\Controllers;

use Mews\Purifier\Facades\Purifier;
use App\Models\tb_soal as Soal;
use App\Models\tb_opsi as Opsi;
use App\Models\tb_paket as Paket;
use App\Models\tb_quiz as Quiz;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use File;
use Str;

use Illuminate\Http\Request;

class AdminContentController extends Controller
{
    // QUIZ / CATEGORY ============================================================================================================
    public function AddNewSubCourseContent(Request $req, $id)
    {
        $paket = Paket::all();
        $id_sub_course = $id;
        return view('admin.input-subcourse-content', [
            'paket' => $paket,
            'id_sub_course' => $id_sub_course
        ]);
    }

    public function PostSubCourseContent(Request $req, $id)
    {
        $req->validate([
            "nama_quiz" => 'required',
            "id_paket" => 'required',
            "durasi" => 'required',
            "is_berbayar" => 'required',
            "video" => 'required|file|mimetypes:video/mp4'
        ]);

        if (!$req->hasFile('video')) {
            return redirect()->back()->with('error', "File Not Found!");
        }
        $video_quiz = $req->file('video');
        $filename = date('YmdHis') . "." . $video_quiz->getClientOriginalExtension();
        $path = public_path() . '/videos/quiz-video/' . $filename;
        if (!File::isDirectory($path))
            File::makeDirectory($path, 0755, true);
        $quiz = Quiz::create([
            'nama_quiz' => $req->nama_quiz,
            'id_paket' => $req->id_paket,
            'id_sub_course' => $id,
            'durasi' => $req->durasi,
            'is_berbayar' => $req->is_berbayar,
            'video' => $filename,
        ]);
        $video_quiz->move($path, $filename);
        return redirect()->back()->with('success', "Quiz Submitted Succesfully!");
    }


    // SOAL =======================================================================================================================
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
            "tipe" => 'required',
            "opsi.*" => $req->input('tipe') === 'deskripsi' ? '' : 'required',
            'jawaban_benar' => $req->input('tipe') === 'deskripsi' ? '' : 'required|array|size:1',
            'jawaban_benar.*' => $req->input('tipe') === 'deskripsi' ? '' : 'integer',
            "audio_soal" => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
            "audio_opsi.*" => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
        ]);

        $content = $req->pertanyaan;
        $dom = new \DomDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            // if(strpos($image->getAttribute('src'),'data:image/')===0){
            $imgeData = base64_decode(explode(',', explode(';', $image->getAttribute('src'))[1])[1]);
            $image_name = "/soal-images/" . time() . $item . '.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $imgeData);

            $image->removeAttribute('src');
            $image->setAttribute('src', $image_name);
            // }
        }
        $content = $dom->saveHTML();

        // Simpan soal dengan tipe deskripsi dan file audio pertanyaan
        if ($req->input('tipe') === 'deskripsi') {
            if ($req->hasFile('audio_soal')) {
                $audio_file = $req->file('audio_soal');
                $audio_extension = $audio_file->getClientOriginalExtension();
                $audio_name = time() . '.' . $audio_extension;
                $audioSoalPath = public_path('audio-soal/' . $audio_name);
                $audio_file->move($audioSoalPath, $audio_name);
                $soal = Soal::create([
                    'pertanyaan' => $content,
                    'tipe' => 'deskripsi',
                    'audio_file' => $audio_name,
                ]);
                return redirect('/admin-create-soal')->with('success', "Submitted Successfully!");
            }
            // simpan tanpa audio
            if (!$req->hasFile('audio_soal')) {
                $soal = Soal::create([
                    'pertanyaan' => $content,
                    'tipe' => 'deskripsi',
                ]);
            }

            return redirect('/admin-create-soal')->with('success', "Submitted Successfully!");
        }

        if ($req->input('tipe') === 'opsi') {
            if ($req->hasFile('audio_soal')) {
                $audio_file = $req->file('audio_soal');
                $audio_extension = $audio_file->getClientOriginalExtension();
                $audio_name = time() . '.' . $audio_extension;
                $audioSoalPath = public_path('audio-soal/' . $audio_name);
                $audio_file->move($audioSoalPath, $audio_name);
                // simpan dengan audio
                $soal = Soal::create([
                    'pertanyaan' => $content,
                    'tipe' => 'opsi',
                    'audio_file' => $audio_name,
                ]);
            }
            // simpan tanpa audio
            if (!$req->hasFile('audio_soal')) {
                $soal = Soal::create([
                    'pertanyaan' => $content,
                    'tipe' => 'opsi',
                ]);
            }
        }

        // Inisialisasi array untuk menyimpan nama file audio
        $audio_names = [];

        // Simpan opsi dan file audio opsi
        if ($req->hasFile('audio_opsi')) {
            $audio_files = $req->file('audio_opsi');

            foreach ($audio_files as $audioOpsi) {
                if ($audioOpsi->isValid()) {
                    $audio_extension = $audioOpsi->getClientOriginalExtension();
                    $audio_name = time() . '_' . rand(1000, 9999) . '.' . $audio_extension;
                    $audioOpsiPath = public_path('audio-opsi/' . $audio_name);
                    $audioOpsi->move($audioOpsiPath, $audio_name);

                    // Simpan nama file audio ke dalam array bersama dengan index opsi
                    $audio_names[] = [
                        'index' => count($audio_names),
                        'name' => $audio_name,
                    ];
                }
            }
        }
        // Simpan opsi
        foreach ($req->input('opsi') as $key => $io) {
            $isJawabanBenar = $req->has('jawaban_benar') && in_array($key, $req->input('jawaban_benar'));

            $dom = new \DomDocument();
            $dom->loadHtml($io, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $imgeData = base64_decode(explode(',', explode(';', $image->getAttribute('src'))[1])[1]);
                $image_name = "/soal-images-opsi/" . time() . '_opsi_' . $key . '_' . $item . '.png';
                $path = public_path() . $image_name;
                file_put_contents($path, $imgeData);
                $image->removeAttribute('src');
                $image->setAttribute('src', $image_name);
            }
            $contentOpsi = $dom->saveHTML();
            /// Mengecek apakah ada file audio yang sesuai dengan opsi saat ini
            $audio_name = null;

            foreach ($audio_names as $audio) {
                if ($audio['index'] == $key) {
                    $audio_name = $audio['name'];
                    break;
                }
            }
            Opsi::create([
                'opsi' => $contentOpsi,
                'audio_file' => $audio_name,
                'id_soal' => $soal->id,
                'is_jawaban_benar' => $isJawabanBenar,
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
        $dom = new \DOMDocument();
        @$dom->loadHTML($soal->pertanyaan, 9);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');
            $path = Str::of($src)->after('/');

            if (File::exists($path)) {
                File::delete($path);
            }
        }
        // Loop untuk gambar opsi
        $opsi = $soal->opsi;
        foreach ($opsi as $opsi) {
            $domOpsi = new \DOMDocument();
            @$domOpsi->loadHTML($opsi->opsi, 9);
            $imagesOpsi = $domOpsi->getElementsByTagName('img');

            foreach ($imagesOpsi as $key => $img) {
                $srcOpsi = $img->getAttribute('src');
                $pathOpsi = Str::of($srcOpsi)->after('/');

                if (File::exists($pathOpsi)) {
                    File::delete($pathOpsi);
                }
            }
        }
        $soal->delete();
        return redirect()->back()->with('success', "Soal and related Opsi deleted successfully!");
    }

    public function UpdateSoal($id)
    {
        $soal = Soal::find($id);
        $opsi = $soal->opsi()->get()->toArray();
        // $jawabanBenar = array_filter($opsi, function ($opsi) {
        //     return $opsi['is_jawaban_benar'] == 1;
        // });
        return view('admin.update-soal', [
            'soal' => $soal,
            'opsi' => $opsi,
        ]);
    }

    public function PostUpdateSoal(Request $req, $id)
    {
        $req->validate([
            "pertanyaan" => 'required',
            "opsi.*" => $req->input('tipe') === 'deskripsi' ? '' : 'required',
            'jawaban_benar' => $req->input('tipe') === 'deskripsi' ? '' : 'required|array|size:1',
            'jawaban_benar.*' => $req->input('tipe') === 'deskripsi' ? '' : 'integer',
        ]);

        $content = $req->pertanyaan;
        $dom = new \DomDocument();
        @$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            if (strpos($image->getAttribute('src'), 'data:image/') === 0) {
                $imageData = base64_decode(explode(',', explode(';', $image->getAttribute('src'))[1])[1]);
                $imageName = "/soal-images/" . time() . $item . '.png';
                $path = public_path() . $imageName;
                file_put_contents($path, $imageData);

                $image->removeAttribute('src');
                $image->setAttribute('src', $imageName);
            }
        }

        $content = $dom->saveHTML();

        // Update soal
        $soal = Soal::find($id);
        $soal->update([
            'pertanyaan' => $content,
            'tipe' => $req->tipe,
        ]);

        // Hapus opsi lama sebelum menambahkan yang baru
        $soal->opsi()->delete();

        // Jika tipe soal adalah "opsi", simpan opsi baru
        if ($req->input('tipe') === 'opsi') {
            foreach ($req->input('opsi') as $key => $io) {
                $isJawabanBenar = $req->input('jawaban_benar')[0] == $key;

                $dom = new \DomDocument();
                @$dom->loadHtml($io, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $imageFile = $dom->getElementsByTagName('img');

                foreach ($imageFile as $item => $image) {
                    if (strpos($image->getAttribute('src'), 'data:image/') === 0) {
                        $imageData = base64_decode(explode(',', explode(';', $image->getAttribute('src'))[1])[1]);
                        $imageName = "/soal-images-opsi/" . time() . '_opsi_' . $key . '_' . $item . '.png';
                        $path = public_path() . $imageName;
                        file_put_contents($path, $imageData);

                        $image->removeAttribute('src');
                        $image->setAttribute('src', $imageName);
                    }
                }

                $contentOpsi = $dom->saveHTML();

                $soal->opsi()->create([
                    'opsi' => $contentOpsi,
                    'is_jawaban_benar' => $isJawabanBenar,
                    'id_soal' => $soal->id
                ]);
            }
        }

        return redirect('/admin-create-soal')->with('success', "Update Successfully!");
    }

    public function DeleteOpsi($id)
    {
        $opsi = Opsi::find($id);
        if (!$opsi) {
            return redirect()->back()->with('error', "Opsi not found!");
        }
        // Dapatkan nama file gambar dari atribut 'opsi'
        $dom = new \DomDocument();
        @$dom->loadHtml($opsi->opsi, 9);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $image) {
            $src = $image->getAttribute('src');
            $path = public_path($src);

            // Hapus file gambar jika ada
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $opsi->delete();
        return redirect()->back()->with('success', "Opsi deleted successfully!");
    }


    // PAKET ======================================================================================================================
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
        $request->validate([
            'nama_paket' => 'required',
            'soal' => 'array', // Pastikan 'soal' adalah array
        ]);

        $paket = Paket::find($id);

        if (!$paket) {
            return redirect()->back()->with('error', 'Paket not found!');
        }

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
