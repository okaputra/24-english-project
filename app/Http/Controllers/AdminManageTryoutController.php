<?php

namespace App\Http\Controllers;

use App\Models\tb_tryout as Tryout;
use App\Models\tb_paket as Paket;
use App\Models\tb_quiz as Quiz;
use Illuminate\Http\Request;

class AdminManageTryoutController extends Controller
{
    public function AdminCreateTryout($id_category)
    {
        $id = $id_category;
        $paket = Paket::all();
        $tryout = Tryout::where('id_quiz', $id)->get();
        return view('admin.input-tryout', [
            'paket' => $paket,
            'id_category' => $id,
            'tryout' => $tryout,
        ]);
    }
    public function AdminPostTryout(Request $request, $id_category)
    {
        $request->validate([
            "id_paket" => 'required',
            "durasi" => 'required',
        ]);
        $category = Quiz::where('id', $id_category)->first();

        Tryout::create([
            'id_quiz' => $id_category,
            'id_paket' => $request->id_paket,
            'id_sub_course' => $category->id_sub_course,
            'durasi' => $request->durasi,
        ]);
        return redirect()->back()->with('success', "Tryout Submitted Succesfully!");
    }
    public function AdminUpdateTryout($id)
    {
        $tryout = Tryout::find($id);
        $paket = Paket::all();
        $paket_terpilih = Paket::where('id', $tryout->id_paket)->first();
        return view('admin.update-tryout', [
            'tryout' => $tryout,
            'paket' => $paket,
            'paket_terpilih' => $paket_terpilih,
        ]);
    }
    public function AdminPostUpdateTryout(Request $request, $id)
    {
        $request->validate([
            "id_paket" => 'required',
            "durasi" => 'required',
        ]);
        $tryout = Tryout::find($id);
        $tryout->update([
            'id_paket' => $request->id_paket,
            'durasi' => $request->durasi,
        ]);

        return redirect("/admin-assign-tryout/$tryout->id_quiz")->with('success', "Tryout Updated Succesfully!");
    }
    public function AdminDeleteTryout($id)
    {
        $tryout = Tryout::find($id);
        $tryout->delete();
        return redirect()->back()->with('success', "Tryout Deleted Succesfully!");
    }
}
