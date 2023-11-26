<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Illuminate\Support\Facades\DB;

class RekapSebaranGuru extends Controller
{
    public function index()
    {
        $bentuk_pendidikan = Ms_DataSekolah::groupBy("bentuk_pendidikan")->get("bentuk_pendidikan");    
        $data = array();
        foreach ($bentuk_pendidikan as $bp) {
            $data[$bp->bentuk_pendidikan]['nama'] = $bp->bentuk_pendidikan;
            $data[$bp->bentuk_pendidikan]['matpel'] = array();
        }

        $id_guru = User::with('bio')->role('guru')->get('id');

        foreach ($id_guru as $id) {
            $arnpsn[$id->id] = "'$id->id'";
            // dd($arnpsn);
            $list = implode(",", $arnpsn);
        }        

        $sql = "SELECT s.bentuk_pendidikan, b.mengajar
        FROM ms_biodatauser as b
        LEFT JOIN ms_sekolah as s on s.npsn = b.asal_satuan_pendidikan
        WHERE b.id in ($list)
        AND b.mengajar is not null
        GROUP BY s.bentuk_pendidikan, b.mengajar";

        $query = DB::select($sql);

        foreach ($query as $q) {
            $data[$q->bentuk_pendidikan]['matpel'][$q->mengajar] = $q->mengajar;
        }
// dd($data);
        return view('rekap.sebaran-guru.index', compact('data'));
    }
}
