<?php

namespace App\Http\Controllers;

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
        $quiz = Quiz::where('id_sub_course', $id_sub_course)->get();
        return view('admin.input-subcourse-content', [
            'paket' => $paket,
            'id_sub_course' => $id_sub_course,
            'quiz' => $quiz
        ]);
    }

    public function PostSubCourseContent(Request $req, $id)
    {
        $req->validate([
            "nama_quiz" => 'required',
            "is_berbayar" => 'required',
            "video" => 'required|file|mimetypes:video/mp4',
            "video_thumbnail" => 'required|image|max:2048|mimes:jpg,jpeg,png'
        ]);

        if (!$req->hasFile('video')) {
            return redirect()->back()->with('error', "File Not Found!");
        }
        $video_quiz = $req->file('video');
        $filename = date('YmdHis') . "." . $video_quiz->getClientOriginalExtension();
        $path = public_path() . '/videos/quiz-video/' . $filename;
        if (!File::isDirectory($path))
            File::makeDirectory($path, 0755, true);

        if (!$req->hasFile('video_thumbnail')) {
            return redirect()->back()->with('error', "File Not Found!");
        }
        $videoThumbnail = $req->file('video_thumbnail');
        $Thumbnailfilename = date('YmdHis') . "." . $videoThumbnail->getClientOriginalExtension();
        $pathThumbnailVideo = public_path() . '/images/video-thumbnail/' . $Thumbnailfilename;
        if (!File::isDirectory($pathThumbnailVideo))
            File::makeDirectory($pathThumbnailVideo, 0755, true);
        Quiz::create([
            'nama_quiz' => $req->nama_quiz,
            'id_paket' => $req->id_paket,
            'id_sub_course' => $id,
            'durasi' => $req->durasi,
            'is_berbayar' => $req->is_berbayar,
            'video_path' => $filename,
            'video_thumbnail' => $Thumbnailfilename,
        ]);
        $video_quiz->move($path, $filename);
        $videoThumbnail->move($pathThumbnailVideo, $Thumbnailfilename);
        return redirect()->back()->with('success', "Quiz Submitted Succesfully!");
    }

    public function UpdateSubCourseContent($id)
    {
        $quiz = Quiz::find($id);
        $paket = Paket::all();
        if ($quiz == NULL || $quiz->id_paket == NULL) {
            $paket_terpilih = NULL;
        } else {
            $paket_terpilih = Paket::where('id', $quiz->id_paket)->first();
        }
        return view('admin.update-subcourse-content', [
            'quiz' => $quiz,
            'paket' => $paket,
            'paket_terpilih' => $paket_terpilih,
        ]);
    }

    public function PostUpdateSubCourseContent(Request $req, $id)
    {
        $req->validate([
            "nama_quiz" => 'required',
            "is_berbayar" => 'required',
        ]);

        $quiz = Quiz::find($id);

        if ($req->file('video')) {
            $video_quiz = $req->file('video');
            $filename = date('YmdHis') . "." . $video_quiz->getClientOriginalExtension();
            $path = public_path() . '/videos/quiz-video/' . $filename;
            $video_quiz->move($path, $filename);
            $quiz->update([
                'video_path' => $filename,
            ]);
        }

        if ($req->file('video_thumbnail')) {
            $videoThumbnail = $req->file('video_thumbnail');
            $Thumbnailfilename = date('YmdHis') . "." . $videoThumbnail->getClientOriginalExtension();
            $pathThumbnailVideo = public_path() . '/images/video-thumbnail/' . $Thumbnailfilename;
            $videoThumbnail->move($pathThumbnailVideo, $Thumbnailfilename);
            $quiz->update([
                'video_thumbnail' => $Thumbnailfilename,
            ]);
        }

        $quiz->update([
            'nama_quiz' => $req->nama_quiz,
            'id_paket' => $req->id_paket,
            'durasi' => $req->durasi,
            'is_berbayar' => $req->is_berbayar,
        ]);

        return redirect("/admin-input-subcourse-content/$quiz->id_sub_course")->with('success', "Quiz Updated Succesfully!");
    }

    public function DeleteSubCourseContent($id)
    {
        $quiz = Quiz::find($id);
        $videoPath = public_path('/videos/quiz-video/' . $quiz->video_path . '/' . $quiz->video_path);
        $videoThumbnailPath = public_path('/images/video-thumbnail/' . $quiz->video_thumbnail . '/' . $quiz->video_thumbnail);
        if (File::exists($videoPath)) {
            File::delete($videoPath);
        }
        if (File::exists($videoThumbnailPath)) {
            File::delete($videoThumbnailPath);
        }

        $quiz->delete();
        return redirect()->back()->with('success', "Quiz Deleted Succesfully!");

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
                    'clue' => $req->clue,
                    'tipe' => 'deskripsi',
                    'audio_file' => $audio_name,
                ]);
                return redirect('/admin-create-soal')->with('success', "Submitted Successfully!");
            }
            // simpan tanpa audio
            if (!$req->hasFile('audio_soal')) {
                $soal = Soal::create([
                    'pertanyaan' => $content,
                    'clue' => $req->clue,
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
                    'clue' => $req->clue,
                    'tipe' => 'opsi',
                    'audio_file' => $audio_name,
                ]);
            }
            // simpan tanpa audio
            if (!$req->hasFile('audio_soal')) {
                $soal = Soal::create([
                    'pertanyaan' => $content,
                    'clue' => $req->clue,
                    'tipe' => 'opsi',
                ]);
            }
        }

        // Inisialisasi array untuk menyimpan nama file audio
        $audio_names = [];

        // Simpan opsi dan file audio opsi
        if ($req->hasFile('audio_opsi')) {
            $audio_files = $req->file('audio_opsi');

            foreach ($req->input('opsi') as $key => $io) {
                // Cek apakah ada file audio yang sesuai dengan opsi saat ini
                $audio_name_opsi = null;

                // Cek apakah ada pengunggahan file audio untuk opsi ini
                if ($req->hasFile('audio_opsi.' . $key)) {
                    $audio_file = $audio_files[$key];
                    $audio_extension = $audio_file->getClientOriginalExtension();
                    $audio_name_opsi = time() . '_' . rand(1000, 9999) . '.' . $audio_extension;
                    $audioOpsiPath = public_path('audio-opsi/' . $audio_name_opsi);
                    $audio_file->move($audioOpsiPath, $audio_name_opsi);
                }

                // Simpan nama file audio ke dalam array bersama dengan index opsi
                $audio_names[$key] = [
                    'name' => $audio_name_opsi,
                ];
            }
        }

        // Simpan opsi baru
        foreach ($req->input('opsi') as $key => $io) {
            $isJawabanBenar = $req->has('jawaban_benar') && in_array($key, $req->input('jawaban_benar'));

            // Lakukan pengolahan teks opsi
            $dom = new \DomDocument();
            $dom->loadHtml($io, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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

            // Tentukan nama file audio untuk opsi saat ini
            $audio_name_opsi = null;
            if (isset($audio_names[$key])) {
                $audio_name_opsi = $audio_names[$key]['name'];
            }

            // Simpan opsi baru ke database
            Opsi::create([
                'opsi' => $contentOpsi,
                'audio_file' => $audio_name_opsi,
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
        @$dom->loadHTML($soal->pertanyaan, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
            @$domOpsi->loadHTML($opsi->opsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $imagesOpsi = $domOpsi->getElementsByTagName('img');

            foreach ($imagesOpsi as $key => $img) {
                $srcOpsi = $img->getAttribute('src');
                $pathOpsi = Str::of($srcOpsi)->after('/');

                if (File::exists($pathOpsi)) {
                    File::delete($pathOpsi);
                }
            }
        }
        if ($soal->audio_file) {
            $audioPath = public_path('audio-soal/' . $soal->audio_file . '/' . $soal->audio_file);
            if (File::exists($audioPath)) {
                File::delete($audioPath);
            }
        }

        if ($soal['tipe'] == 'opsi') {
            if ($opsi->audio_file) {
                $audioPath = public_path('audio-opsi/' . $opsi->audio_file . '/' . $opsi->audio_file);
                if (File::exists($audioPath)) {
                    File::delete($audioPath);
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
            "audio_soal" => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
            "audio_opsi.*" => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
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
        $soal = Soal::find($id);

        // Simpan soal dengan tipe deskripsi dan file audio pertanyaan
        if ($req->input('tipe') === 'deskripsi') {
            $audio_name_soal = null;
            // Cek apakah ada penggantian audio soal
            if ($req->hasFile('audio_soal')) {
                $audio_file_soal = $req->file('audio_soal');
                $audio_extension_soal = $audio_file_soal->getClientOriginalExtension();
                $audio_name_soal = time() . '.' . $audio_extension_soal;
                $audioSoalPath = public_path('audio-soal/' . $audio_name_soal);
                $audio_file_soal->move($audioSoalPath, $audio_name_soal);
            } elseif ($soal->audio_file) {
                // Gunakan audio yang sudah ada jika tidak ada penggantian
                $audio_name_soal = $soal->audio_file;
            }

            // Update soal
            $soal->update([
                'pertanyaan' => $content,
                'clue' => $req->clue,
                'tipe' => $req->tipe,
                'audio_file' => $audio_name_soal,
            ]);
        }

        // Simpan soal dengan tipe opsi, cek audio pada soal dan cek juga audio beserta konten pada opsi
        if ($req->input('tipe') === 'opsi') {
            $audio_name_soal = null;
            // Cek apakah ada penggantian audio soal
            if ($req->hasFile('audio_soal')) {
                $audio_file_soal = $req->file('audio_soal');
                $audio_extension_soal = $audio_file_soal->getClientOriginalExtension();
                $audio_name_soal = time() . '.' . $audio_extension_soal;
                $audioSoalPath = public_path('audio-soal/' . $audio_name_soal);
                $audio_file_soal->move($audioSoalPath, $audio_name_soal);
            } elseif ($soal->audio_file) {
                // Gunakan audio yang sudah ada jika tidak ada penggantian
                $audio_name_soal = $soal->audio_file;
            }

            // Update soal
            $soal->update([
                'pertanyaan' => $content,
                'clue' => $req->clue,
                'tipe' => $req->tipe,
                'audio_file' => $audio_name_soal,
            ]);

            // Simpan opsi lama
            $old_opsi = $soal->opsi;
            // dd($old_opsi);

            $jumlah_opsi = count($req->input('opsi'));
            // Inisialisasi array untuk menyimpan nama file audio
            $audio_names = [];

            // Simpan opsi dan file audio opsi
            if ($req->hasFile('audio_opsi')) {
                $audio_files = $req->file('audio_opsi');

                foreach ($old_opsi as $key => $opsi) {
                    // Cek apakah ada file audio yang sesuai dengan opsi saat ini
                    $audio_name_opsi = null;

                    // Cek apakah ada penggantian audio opsi
                    if ($key < $jumlah_opsi && $req->hasFile('audio_opsi.' . $key)) {
                        // Audio file baru diunggah, gunakan yang baru
                        $audio_file = $audio_files[$key];
                        $audio_extension = $audio_file->getClientOriginalExtension();
                        $audio_name_opsi = time() . '_' . rand(1000, 9999) . '.' . $audio_extension;
                        $audioOpsiPath = public_path('audio-opsi/' . $audio_name_opsi);
                        $audio_file->move($audioOpsiPath, $audio_name_opsi);
                    } elseif (isset($opsi->audio_file)) {
                        // Gunakan audio opsi yang sudah ada jika tidak ada penggantian
                        $audio_name_opsi = $opsi->audio_file;
                    }

                    // Simpan nama file audio ke dalam array bersama dengan index opsi
                    $audio_names[] = [
                        'index' => $key,
                        'name' => $audio_name_opsi,
                    ];
                }
            }

            // Update atau buat opsi
            foreach ($old_opsi as $key => $existingOpsi) {
                $isJawabanBenar = $req->input('jawaban_benar')[0] == $key;

                // Temukan opsi yang cocok pada data yang dikirimkan
                $submittedOpsi = $req->input('opsi.' . $key);
                $submittedAudioId = $req->input('audio_opsi_id.' . $key);

                $dom = new \DomDocument();
                @$dom->loadHtml($submittedOpsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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

                // Cek apakah ada penggantian audio opsi
                $audio_name_opsi = null;
                if ($req->hasFile('audio_opsi')) {
                    foreach ($audio_names as $audio) {
                        if ($audio['index'] == $submittedAudioId) {
                            $audio_name_opsi = $audio['name'];
                            break;
                        }
                    }
                } elseif ($existingOpsi->audio_file) {
                    // Gunakan audio opsi yang sudah ada jika tidak ada penggantian
                    $audio_name_opsi = $existingOpsi->audio_file;
                }

                // Update atau buat opsi
                if ($submittedOpsi) {
                    $existingOpsi->update([
                        'opsi' => $contentOpsi,
                        'audio_file' => $audio_name_opsi,
                        'is_jawaban_benar' => $isJawabanBenar,
                    ]);
                } else {
                    // Jika tidak ada opsi yang di-submit, mungkin terjadi kesalahan
                    return redirect('/admin-create-soal')->with('error', "Opsi tidak ditemukan.");
                }
            }

            // Proses penambahan opsi baru
            for ($i = count($old_opsi); $i < $jumlah_opsi; $i++) {
                $isJawabanBenar = $req->has('jawaban_benar') && in_array($key, $req->input('jawaban_benar'));
                $newOpsi = $req->input('opsi.' . $i);

                if ($newOpsi) {
                    $dom = new \DomDocument();
                    @$dom->loadHtml($newOpsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
            }
        }
        return redirect('/admin-create-soal')->with('success', "Berhasil Diperbarui!");
    }

    public function DeleteOpsi($id)
    {
        $opsi = Opsi::find($id);
        if (!$opsi) {
            return redirect()->back()->with('error', "Opsi not found!");
        }
        // Dapatkan nama file gambar dari atribut 'opsi'
        $dom = new \DomDocument();
        @$dom->loadHtml($opsi->opsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $image) {
            $src = $image->getAttribute('src');
            $path = public_path($src);

            // Hapus file gambar jika ada
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        if ($opsi->audio_file) {
            $audioPath = public_path('audio-opsi/' . $opsi->audio_file . '/' . $opsi->audio_file);
            if (File::exists($audioPath)) {
                File::delete($audioPath);
            }
        }
        $opsi->delete();
        return redirect()->back()->with('success', "Opsi deleted successfully!");
    }

    public function DeleteAudioSoal($id)
    {
        $soal = Soal::find($id);
        if ($soal->audio_file) {
            $audioPath = public_path('audio-soal/' . $soal->audio_file . '/' . $soal->audio_file);
            if (File::exists($audioPath)) {
                File::delete($audioPath);
            }
        }
        $soal->update([
            'audio_file' => NULL,
        ]);
        return redirect()->back()->with('success', "Audio Soal deleted successfully!");
    }

    public function DeleteAudioOpsi($id)
    {
        $opsi = Opsi::find($id);
        if ($opsi->audio_file) {
            $audioPath = public_path('audio-opsi/' . $opsi->audio_file . '/' . $opsi->audio_file);
            if (File::exists($audioPath)) {
                File::delete($audioPath);
            }
        }
        $opsi->update([
            'audio_file' => NULL,
        ]);
        return redirect()->back()->with('success', "Audio Opsi deleted successfully!");
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
        // Ambil dan tampilkan hanya soal yang belum terpilih
        $soal_all = Soal::whereNotIn('id', $soal_terpilih_ids)->get();
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
