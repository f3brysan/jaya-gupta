<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Illuminate\Support\Facades\DB;

class RekapPensiunController extends Controller
{
    public function index()
    {
        $yearNow = date('Y');
        $lahir = date('Y') - 65;
        $limit = 5;
        $tahun = array();
        $j = 0;
        $l = 0;

        $bentuk_pendidikan = Ms_DataSekolah::groupBy("bentuk_pendidikan")->whereIn('bentuk_pendidikan', ['TK','SD','SMP'])->get("bentuk_pendidikan");
        for ($i = 0; $i < $limit; $i++) {
            $tahun[$j++]['tahun'] = $yearNow++;
            $tahun[$l++]['lahir'] = $lahir++;
        }

        $data = array();
        $total = array();

        foreach ($tahun as $thn) {
            foreach ($bentuk_pendidikan as $bp) {                
                $data[$bp->bentuk_pendidikan]['nama'] = $bp->bentuk_pendidikan;                
                $data[$bp->bentuk_pendidikan]['tahun'][$thn['tahun']]['Negeri'] = 0;
                $data[$bp->bentuk_pendidikan]['tahun'][$thn['tahun']]['Swasta'] = 0;
                $total[$thn['tahun']]['Total'] = 0;
            }

            $sql_negeri = "SELECT s.bentuk_pendidikan, COALESCE(count(b.*),0) as tot
            FROM ms_biodatauser as b
            LEFT JOIN ms_sekolah as s on s.npsn = b.asal_satuan_pendidikan
            WHERE date_part('year', b.tanggallahir) = $thn[lahir] AND s.status_sekolah = 'Negeri'
            GROUP BY s.bentuk_pendidikan";

            $q_negeri = DB::select($sql_negeri);

            foreach ($q_negeri as $n) {
                $data[$n->bentuk_pendidikan]['tahun'][$thn['tahun']]['Negeri'] = $n->tot;
                $total[$thn['tahun']]['Total'] += $n->tot;
            }

            $sql_swasta = "SELECT s.bentuk_pendidikan, COALESCE(count(b.*),0) as tot
            FROM ms_biodatauser as b
            LEFT JOIN ms_sekolah as s on s.npsn = b.asal_satuan_pendidikan
            WHERE date_part('year', b.tanggallahir) = $thn[lahir] AND s.status_sekolah = 'Swasta'
            GROUP BY s.bentuk_pendidikan";

            $sql_swasta = DB::select($sql_swasta);

            foreach ($sql_swasta as $n) {
                $data[$n->bentuk_pendidikan]['tahun'][$thn['tahun']]['Swasta'] = $n->tot;
                $total[$thn['tahun']]['Total'] += $n->tot;
            }
        }

        // dd($data);  

        $arrnpsn = Ms_DataSekolah::get()->pluck('npsn');

// dd($data);
ksort($data);
ksort($total);

        return view('rekap.pensiun.index', compact('tahun', 'data', 'total'));
    }

    public function show_pendidikan($thn, $bp)
    {
        // dd($thn);
        $lahir = $thn - 65;       
        // dd($lahir);
        $data = array();       
        $sql_pensiun = "SELECT b.asal_satuan_pendidikan, s.nama, COALESCE(count(b.*),0) as tot
        FROM ms_biodatauser as b
        LEFT JOIN ms_sekolah as s on s.npsn = b.asal_satuan_pendidikan
        WHERE date_part('year', b.tanggallahir) = '$lahir' 
        GROUP BY b.asal_satuan_pendidikan, s.nama";
        $q_pensiun = DB::select($sql_pensiun);
        
        
        if (count($q_pensiun) > 0) {
            foreach ($q_pensiun as $p) {
                $data[$p->asal_satuan_pendidikan]['npsn'] = $p->asal_satuan_pendidikan;
                $data[$p->asal_satuan_pendidikan]['nama'] = $p->nama;
                $data[$p->asal_satuan_pendidikan]['pensiun'] = $p->tot;
            }
        }

        return view('rekap.pensiun.show', compact('thn', 'data'));        
    }

    public function show_sekolah($npsn, $thn)
    {
        $lahir = $thn-65;
        $data = array();

        $sekolah = Ms_DataSekolah::where('npsn', $npsn)->first();

        $sql = "SELECT b.*, s.nama as nm_sekolah
        FROM ms_biodatauser as b
        LEFT JOIN ms_sekolah as s on s.npsn = b.asal_satuan_pendidikan
        WHERE date_part('year', b.tanggallahir) = '$lahir'";

        $getBio = DB::select($sql);

        return view('rekap.pensiun.detail', compact('sekolah', 'getBio' ,'thn'));        
    }
}
