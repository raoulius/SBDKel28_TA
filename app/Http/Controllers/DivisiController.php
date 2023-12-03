<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DivisiController extends Controller
{
    public function index(){
        $divisis = DB::select('SELECT * FROM divisi where is_deleted = 0');

        return view('divisi.index')
        ->with('divisis', $divisis);
    }

    public function create(){
        return view('divisi.add');
    }

    public function store (Request $request) {
        $request->validate([
            'nama_divisi' => 'required',
            'desc_divisi' => 'required'


        ]);

        DB::insert('INSERT INTO divisi(nama_divisi, desc_divisi) VALUES (:nama_divisi, :desc_divisi)',
        [
            'nama_divisi' => $request->nama_divisi, 
            'desc_divisi' => $request->desc_divisi
        ]
        );

        return redirect()->route('divisi.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id) {
        $data = DB::table('divisi')->where('id_divisi', $id)->first();
        return view('divisi.edit')->with('data', $data);
    }

    public function update($id, Request $request) {
        $request->validate([
            'nama_divisi' => 'required',
            'desc_divisi' => 'required',
        ]);

        DB::table('divisi')->where('id_divisi', $id)->update(array(
            'nama_divisi' => $request->nama_divisi, 
            'desc_divisi' => $request->desc_divisi
        ));


        return redirect()->route('divisi.index')->with('success', 'Data berhasil diubah');
    }

    public function delete($id) {
        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::delete('DELETE FROM divisi WHERE id_divisi = :id_divisi', ['id_divisi' => $id]);

        // Menggunakan laravel eloquent
        // meja::where('id_meja', $id)->delete();

        return redirect()->route('divisi.index')->with('success', 'Data  berhasil dihapus');
    }

    public function caridivisi(Request $request) {
        $cari = $request->caridivisi;

        $datas = DB::table('divisi')->where('', 'like', "%".$cari."%");

        return view('divisi.index')
            ->with('datas', $datas);


    }

    public function softDelete($id) {
        DB::update('UPDATE divisi SET is_deleted = 1 WHERE id_divisi = :id_divisi', ['id_divisi' => $id]);
        return redirect()->route('divisi.index')->with('success', 'Data dihapus sementara');
    }

    public function restore($id){
        // DB::table('meja')->update(['is_deleted' => 0]);
        DB::update('UPDATE divisi SET is_deleted = 0 WHERE id_divisi = :id_divisi = 1', ['id_divisi' => $id]);

        return redirect()->route('divisi.bin')->with('success', 'Data direstore');
    }

    public function Divisibin(){
        $divisis = DB::select('SELECT * FROM divisi where is_deleted = 1');


        return view('divisi.bin')
        ->with('divisis', $divisis);

    }
}
