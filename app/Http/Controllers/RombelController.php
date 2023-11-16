<?php

namespace App\Http\Controllers;

use App\Models\Ms_Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RombelController extends Controller
{
    public function index()
    {
        $npsn = auth()->user()->bio->asal_satuan_pendidikan;
        $kelas = array();
        $rombel = Ms_Rombel::with('walikelas')->get();

        $sql_count = "SELECT
        pd.rombel,
        SUM ( CASE WHEN pd.jk = 'L' THEN 1 ELSE 0 END ) as L,
        SUM ( CASE WHEN pd.jk = 'P' THEN 1 ELSE 0 END ) as P,
        COUNT (pd.nik) AS total
        FROM
        tr_pesertadidik AS pd
        WHERE sekolah_npsn = '$npsn'
        GROUP BY pd.rombel";
        $hitung_siswa = DB::select($sql_count);

        foreach ($rombel as $item) {
            $kelas[$item->nama_rombel]['id'] = $item->id;
            $kelas[$item->nama_rombel]['nama_rombel'] = $item->nama_rombel;
            $kelas[$item->nama_rombel]['tingkat_kelas'] = $item->tingkat_kelas;
            $kelas[$item->nama_rombel]['wali_kelas'] = $item->wali_kelas;
            $kelas[$item->nama_rombel]['ruangan'] = $item->ruangan;
            $kelas[$item->nama_rombel]['kurikulum'] = $item->kurikulum;
            $kelas[$item->nama_rombel]['nm_wali'] = $item->walikelas->nama;

            foreach ($hitung_siswa as $htg) {
                $kelas[$item->nama_rombel]['L'] = $htg->l;
                $kelas[$item->nama_rombel]['P'] = $htg->p;
                $kelas[$item->nama_rombel]['total'] = $htg->total;
            }
        }        

        return view('data-rombel.index', compact('kelas'));
    }
}
