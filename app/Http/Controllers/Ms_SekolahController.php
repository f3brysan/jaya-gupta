<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class Ms_SekolahController extends Controller
{
    public function index()
    {
        $semester_id = date('Y').'1';
        $source = Http::get("https://dapo.kemdikbud.go.id/rekap/dataSekolah?id_level_wilayah=2&kode_wilayah=226000&semester_id=".$semester_id."");

        $getData = $source->json();                

        return view('master.sekolah.index', compact('getData'));
    }

    public function sekolah_kec($id_level_wil, $kode_wil, Request $request)
    {
        $semester_id = date('Y').'1';
        $kode_wil = Crypt::decrypt($kode_wil);
        $url = "https://dapo.kemdikbud.go.id/rekap/progresSP?id_level_wilayah=".$id_level_wil."&kode_wilayah=".$kode_wil."&semester_id=20231&bentuk_pendidikan_id=";
        $source = Http::get($url);
        $getData = $source->json();  
        
        if ($request -> ajax()) {
            return DataTables::of($getData)            
            ->rawColumns([])
            ->addIndexColumn()
            ->make(true);
        }

        $total = array();
        $total['pd'] = 0;
        $total['rombel'] = 0;
        $total['ptk'] = 0;
        $total['pegawai'] = 0;
        $total['jml_lab'] = 0;
        $total['jml_rk'] = 0;
        $total['jml_perpus'] = 0;
        foreach ($getData as $data) {
            $total['pd'] += $data['pd'];
            $total['rombel'] += $data['rombel'];
            $total['ptk'] += $data['ptk'];
            $total['pegawai'] += $data['pegawai'];
            $total['jml_lab'] += $data['jml_lab'];
            $total['jml_rk'] += $data['jml_rk'];
            $total['jml_perpus'] += $data['jml_perpus'];
        }
        // return $total;

        $nm_induk_kecamatan = $getData[0]['induk_kecamatan'];
        return view('master.sekolah.show', compact('nm_induk_kecamatan','total'));
    }
}
