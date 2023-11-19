<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Ms_Rombel;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

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
            $kelas[$item->nama_rombel]['L'] = 0;
            $kelas[$item->nama_rombel]['P'] = 0;
            $kelas[$item->nama_rombel]['total'] = 0;

            foreach ($hitung_siswa as $htg) {
                if ($htg->rombel == $item->nama_rombel) {
                    $kelas[$htg->rombel]['L'] += $htg->l;
                    $kelas[$htg->rombel]['P'] += $htg->p;
                    $kelas[$htg->rombel]['total'] = $htg->total;
                }

            }
        }

        ksort($kelas);

        return view('data-rombel.index', compact('kelas'));
    }

    public function create()
    {
        $npsn = auth()->user()->bio->asal_satuan_pendidikan;
        $bioguru = User::with('bio', 'roles');
        $guru = $bioguru->whereHas('bio', function ($q) use ($npsn) {
            $q->where('asal_satuan_pendidikan', $npsn);
        })
            ->role('guru')
            ->get();

        return view('data-rombel.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $create = Ms_Rombel::updateOrCreate(['id' => $request->id],[
            'sekolah_npsn' => auth()->user()->bio->asal_satuan_pendidikan,
            'nama_rombel' => $request->nama_rombel,
            'tingkat_kelas' => $request->tingkat_kelas,
            'wali_kelas' => $request->wali_kelas,
            'ruangan' => $request->ruangan,
            'kurikulum' => $request->kurikulum
        ]);

        if ($create) {
            return redirect(URL::to('data-rombel'))->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $npsn = auth()->user()->bio->asal_satuan_pendidikan;
        $bioguru = User::with('bio', 'roles');
        $guru = $bioguru->whereHas('bio', function ($q) use ($npsn) {
            $q->where('asal_satuan_pendidikan', $npsn);
        })
            ->role('guru')
            ->get();
        $rombel = Ms_Rombel::where('id', $id)->first();
        return view('data-rombel.edit', compact('guru', 'rombel'));
    }

    public function destroy(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        $delete = Ms_Rombel::where('id', $id)->delete();

        if ($delete) {
            return redirect(URL::to('data-rombel'))->with('success', 'Data berhasil dihapus.');
        }
    }
}
