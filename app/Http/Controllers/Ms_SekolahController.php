<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class Ms_SekolahController extends Controller
{
    public function index()
    {
        $semester_id = date('Y') . '1';
        $source = Http::get("https://dapo.kemdikbud.go.id/rekap/dataSekolah?id_level_wilayah=2&kode_wilayah=226000&semester_id=" . $semester_id . "");

        $getData = $source->json();

        return view('master.sekolah.index', compact('getData'));
    }

    public function sekolah_kec($id_level_wil, $kode_wil, Request $request)
    {
        $semester_id = date('Y') . '1';
        $kode_wil = Crypt::decrypt($kode_wil);
        $url = "https://dapo.kemdikbud.go.id/rekap/progresSP?id_level_wilayah=" . $id_level_wil . "&kode_wilayah=" . $kode_wil . "&semester_id=20231&bentuk_pendidikan_id=";
        $source = Http::get($url);
        
        $getData = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', "like", '%'.$kode_wil.'%')->get();
        
        if ($request->ajax()) {
            return DataTables::of($getData)
            ->addColumn('nama', function ($getData) {
                $url = 'data-sekolah/show-detail/'.$getData->sekolah_id;
                return '<a href="'.URL::to($url).'">'.$getData->nama.'</a>';
            })
                ->rawColumns(['nama'])
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

        $nm_induk_kecamatan = $getData[0]['induk_kecamatan'] ?? '';
        // $kode_wil = trim($getData[0]['kode_wilayah_induk_kecamatan']) ?? '';
        return view('master.sekolah.show', compact('nm_induk_kecamatan', 'total', 'kode_wil'));
    }

    public function detil_sekolah($npsn)
    {
        $npsn = Crypt::decrypt($npsn);
        $getData = Ms_DataSekolah::where('npsn', $npsn)->first();
        return view('master.sekolah.show_detil', compact('getData'));
    }

    public function edit_sekolah($npsn)
    {
        $npsn = Crypt::decrypt($npsn);
        $getData = Ms_DataSekolah::where('npsn', $npsn)->first();
        return view('master.sekolah.edit_detil', compact('getData'));
    }

    public function update_sekolah(Request $request)
    {
        
        $record = $request->all();
        unset($record['_token']);
        // dd($record);
        DB::beginTransaction();
        $update = Ms_DataSekolah::where('npsn', $request->npsn)->update($record);
        $npsn_enkripsi = Crypt::encrypt($request->npsn);

        if ($update) {
            DB::commit();
            return redirect('data-sekolah/edit-detail/'.$npsn_enkripsi)->with('success', 'Data berhasil disimpan.');
        }

    }

    public function pull_data(Request $request)
    {
        try {
            $kode_wil = $request->kode_wil;
            $url = "https://dapo.kemdikbud.go.id/rekap/progresSP?id_level_wilayah=3&kode_wilayah=" . $kode_wil . "&semester_id=20231&bentuk_pendidikan_id=";
            $source = Http::get($url);
            $dataDapo = $source->json();
            $dapo = array();
            foreach ($dataDapo as $data) {
                $dapo[$data['sekolah_id']] = $data;
            }
            // cek data pada DB
            $ms_sekolah = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', 'like', $kode_wil . '%')->get()->toArray();
            $sekolah = array();
            foreach ($ms_sekolah as $data) {                        
                $sekolah[strtoupper($data['sekolah_id'])] = $data;
            }
            
            // cek perbedaan Data
            $array_diff = array_diff_key($dapo, $sekolah);            
            $count = count($array_diff);            
            $newData = 0;
            
            if ($count > 0) {
                DB::beginTransaction();
                foreach ($array_diff as $data) {
                    $data['created_at'] = now();        
                    $exe = Ms_DataSekolah::insert($data);
                    if ($exe) {
                        $newData += 1;
                    }
                }
            }

            if ($newData == $count) {
                DB::commit();
                return response()->json($newData);
            } else {
                DB::rollBack();
                return response()->json(false);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

    }
}