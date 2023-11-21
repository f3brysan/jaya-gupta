<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $bentuk_pendidikan = Ms_DataSekolah::groupBy("bentuk_pendidikan")->get("bentuk_pendidikan");

        $data = array();
        foreach ($bentuk_pendidikan as $bp) {
            $sql = "SELECT
            kode_wilayah_induk_kecamatan as kode_wil,
            induk_kecamatan,
            -- id_level_wilayah,
            SUM ( CASE bentuk_pendidikan WHEN '$bp->bentuk_pendidikan' THEN 1 ELSE 0 END ) AS value 	
        FROM
            ms_sekolah 
        GROUP BY
            induk_kecamatan,
            kode_wilayah_induk_kecamatan";
            $query = DB::select($sql);

            foreach ($query as $q) {
                $data[$q->kode_wil]['kode_wil'] = $q->kode_wil;
                $data[$q->kode_wil]['id_level_wilayah'] = 3;
                $data[$q->kode_wil]['nama'] = $q->induk_kecamatan;
                $data[$q->kode_wil][$bp->bentuk_pendidikan] = $q->value;                
            }
        }        
        $total_sekolah = Ms_DataSekolah::select("induk_kecamatan","kode_wilayah_induk_kecamatan as kode_wil", DB::raw('count(*) as total'))->groupBy("induk_kecamatan", "kode_wilayah_induk_kecamatan")->get();

        foreach ($total_sekolah as $item) {
            $data[$item->kode_wil]['total'] = $item->total;
        }
        $getData = $data;
        
        return view('master.sekolah.index', compact('getData'));
    }

    public function sekolah_kec($id_level_wil, $kode_wil, Request $request)
    {
        $semester_id = date('Y') . '1';
        $kode_wil = Crypt::decrypt($kode_wil);
        // dd($kode_wil);
        $url = "https://dapo.kemdikbud.go.id/rekap/progresSP?id_level_wilayah=" . $id_level_wil . "&kode_wilayah=" . $kode_wil . "&semester_id=20231&bentuk_pendidikan_id=";
        $source = Http::get($url);
        
        $getData = Ms_DataSekolah::with('guru')->where('kode_wilayah_induk_kecamatan', $kode_wil)->get();        
        $sekolah_pluck = $getData->pluck('npsn');            
        
        if ($request->ajax()) {
            return DataTables::of($getData)
            ->addColumn('nama', function ($getData) {
                $url = 'data-sekolah/show-detail/'.Crypt::encrypt($getData->npsn);;
                return '<a href="'.URL::to($url).'">'.$getData->nama.'</a>';
            })
            ->addColumn('total_guru', function ($getData) {
                $npsn = $getData->npsn;
                $user = User::with('bio')->whereHas('bio', function($q) use ($npsn){
                    $q->where('asal_satuan_pendidikan', $npsn);
                })->role('guru')->count();
                return $user;                
            })
            ->addColumn('total_tendik', function ($getData) {
                $npsn = $getData->npsn;
                $user = User::with('bio')->whereHas('bio', function($q) use ($npsn){
                    $q->where('asal_satuan_pendidikan', $npsn);
                })->role('tendik')->count();
                return $user;                
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
        $total['tendik'] = User::with('bio')->whereHas('bio', function($q) use ($sekolah_pluck){
            $q->whereIn('asal_satuan_pendidikan', $sekolah_pluck);
        })->role('tendik')->count();
        $total['guru'] = User::with('bio')->whereHas('bio', function($q) use ($sekolah_pluck){
            $q->whereIn('asal_satuan_pendidikan', $sekolah_pluck);
        })->role('guru')->count();
        // foreach ($getData as $data) {           
        //     $total['ptk'] += count($data['guru']);
        //     $total['pegawai'] += $data['pegawai'];            
        // }
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
                    $data['kode_wilayah_induk_kecamatan'] = trim($data['kode_wilayah_induk_kecamatan']);
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