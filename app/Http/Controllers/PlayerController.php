<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use app\Http\Controllers\TeamController;
use app\Http\Controllers\PlayerController;
use app\Http\Controllers\DivisiController;
use App\Models\Divisi;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    public function index(){
        $players = DB::select('SELECT * FROM player WHERE is_deleted = 0');


        return view('player.index')
        ->with('players', $players);

    }

    public function create(){

        $divisis = Divisi::all();
        $teams = Team::all();
        return view('player.add', compact('divisis', 'teams'));
    }

    public function store (Request $request) {
        $request->validate([
            'nickname' => 'required',
            'roles' => 'required',
            'id_divisi' => 'required',
            'id_team' => 'required'
        ]);

        DB::insert('INSERT INTO player(nickname, roles,  id_divisi, id_team) VALUES (:nickname, :roles, :id_divisi,  :id_team)',
        [
            'nickname' => $request->nickname,
            'roles' => $request->roles,
            'id_divisi' => $request->id_divisi,
            'id_team' => $request->id_team
        ]
        );

        return redirect()->route('player.index')->with('success', 'Data berhasil disimpan');
    }
    public function edit($id) {
        $data = DB::table('player')->where('id_player',
        $id)->first();

        return view('player.edit')->with('data', $data);
    }

    public function update($id, Request $request) {
        $request->validate([
            'nickname' => 'required',
            'roles' => 'required',
            'id_divisi' => 'required',
            'id_team' => 'required'
        ]);

        DB::table('player')->where('id_player', $id)->update(array(
            'nickname' => $request->nickname, 
            'roles' => $request->roles,
            'id_divisi' => $request->id_divisi,
            'id_team' => $request->id_team
        ));

        return redirect()->route('player.index')->with('success', 'Data berhasil diubah');
    }
    public function delete($id) {
        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::delete('DELETE FROM player WHERE id_player = :id_player', ['id_player' => $id]);

        // Menggunakan laravel eloquent
        // reservasi::where('id_reservasi', $id)->delete();

        return redirect()->route('player.index')->with('success', 'Data  berhasil dihapus');
    }

    public function cariplayer(Request $request) {
        $cari = $request->cariplayer;

        $datas = DB::table('player')->where('id_player', 'like', "%".$cari."%");

        return view('player.index')
            ->with('datas', $datas);
    }

    public function cariteam(Request $request) {
        $cariteam = $request->cariteam;

        $joins = DB::table('player')
        ->join('team', 'player.id_team', '=', 'team.id_team')
        ->join('divisi', 'player.id_divisi', '=', 'divisi.id_divisi')
        ->select('player.id_player', 'team.nama_team', 'divisi.nama_divisi', 'team.tahun_dibentuk', 'player.nickname', 'player.roles' )
        ->where('nama_team', 'like', "%$cariteam%")
        ->orWhere('id_player', 'like', "%$cariteam%")
        ->orWhere('nickname', 'like', "%$cariteam%")
        ->orWhere('nama_divisi', 'like', "%$cariteam%")
        ->orWhere('tahun_dibentuk', 'like', "%$cariteam%")
        ->orWhere('nickname', 'like', "%$cariteam%")
        ->get();

        return view('index')
        ->with('joins', $joins);


    }

    public function home(){
        $joins = DB::table('player')
        ->join('team', 'player.id_team', '=', 'team.id_team')
        ->join('divisi', 'player.id_divisi', '=', 'divisi.id_divisi')
        ->select('player.id_player', 'team.nama_team', 'divisi.nama_divisi', 'team.tahun_dibentuk', 'player.nickname', 'player.roles' )
        ->get();

        return view('index')

        ->with('joins', $joins);
    }
    public function softDelete($id) {
        DB::update('UPDATE player SET is_deleted = 1 WHERE id_player = :id_player', ['id_player' => $id]);
        return redirect()->route('player.index')->with('success', 'Data dihapus sementara');
    }

    public function restore($id){
        // DB::table('pelanggan')->update(['is_deleted' => 0]);
        DB::update('UPDATE player SET is_deleted = 0 WHERE id_player = :id_player = 1', ['id_player' => $id]);

        return redirect()->route('player.bin')->with('success', 'Data direstore');
    }

    public function Playerbin(){
        $players = DB::select('SELECT * FROM player where is_deleted = 1');

        return view('player.bin')
        ->with('players', $players);

    }
}
