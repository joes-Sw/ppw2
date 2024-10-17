<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BukuModel::all()->sortBy('id');
        $coba = DB::table('buku')->get();
        $total_data = BukuModel::count();
        $total_harga = BukuModel::sum('harga');
        return view('pertemuan5.buku', compact('data','total_data','total_harga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pertemuan5.tambahbuku');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tambah_buku = BukuModel::insert([
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'harga' => $request->input('harga'),
            'tgl_terbit' => $request->input('tgl_terbit'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($request->all());
        if($tambah_buku){
            return redirect('/buku')->with('success', 'berhasil menambahkan data');
        } else {
            return "data yang di input gagal";
        };
    }

    private function getBuku($id)
    {
        return collect(BukuModel::where('id', $id)->get())->firstOrFail();
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = $this->getBuku($id);
        return view('pertemuan5.editbuku', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'id' => $request->input('id'),
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'harga' => $request->input('harga'),
            'tgl_terbit' => $request->input('tgl_terbit'),
        ];

        $update_buku = BukuModel::where('id', '=', $id)->update($data);
        if($update_buku){
            return redirect('/buku')->with('success', 'berhasil mengubah data');
        } else {
            return back();
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete_buku = BukuModel::where('id', $id)->delete();
        if ($delete_buku){
            return back();
        };
    }
}
