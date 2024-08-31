<?php

namespace App\Http\Controllers;

use App\Models\Ms_DataSekolah;
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
        $rombel = Ms_Rombel::with('walikelas')->where('sekolah_npsn', $npsn)->get();

        $sql_count = "SELECT
        pd.rombel,
        SUM ( CASE WHEN pd.jk = 'L' THEN 1 ELSE 0 END ) as L,
        SUM ( CASE WHEN pd.jk = 'P' THEN 1 ELSE 0 END ) as P,
        COUNT (pd.nik) AS total
        FROM
        tr_pesertadidik AS pd
        WHERE pd.sekolah_npsn = '$npsn'
        GROUP BY pd.rombel";

        // dd($sql_count);
        $hitung_siswa = DB::select($sql_count);
        
        foreach ($rombel as $item) {
            $kelas[$item->id]['id'] = $item->id;
            $kelas[$item->id]['nama_rombel'] = $item->nama_rombel;
            $kelas[$item->id]['tingkat_kelas'] = $item->tingkat_kelas;
            $kelas[$item->id]['wali_kelas'] = $item->wali_kelas;
            $kelas[$item->id]['ruangan'] = $item->ruangan;
            $kelas[$item->id]['kurikulum'] = $item->kurikulum;
            $kelas[$item->id]['nm_wali'] = $item->walikelas->nama ?? 'Belum diseting';
            $kelas[$item->id]['L'] = 0;
            $kelas[$item->id]['P'] = 0;
            $kelas[$item->id]['total'] = 0;

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
        $rombelFromPesertaDidik = DB::table('tr_pesertadidik')->where('sekolah_npsn', $npsn)->select('rombel')->groupBy('rombel')->get();
        
        $bioguru = User::with('bio', 'roles');
        $guru = $bioguru->whereHas('bio', function ($q) use ($npsn) {
            $q->where('asal_satuan_pendidikan', $npsn);
        })
            ->role('guru')
            ->get();

        return view('data-rombel.create', compact('guru', 'rombelFromPesertaDidik'));
    }

    public function store(Request $request)
    {
        $create = Ms_Rombel::updateOrCreate(['id' => $request->id], [
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
        $rombelFromPesertaDidik = DB::table('tr_pesertadidik')->where('sekolah_npsn', $npsn)->select('rombel')->groupBy('rombel')->get();
        return view('data-rombel.edit', compact('guru', 'rombel', 'rombelFromPesertaDidik'));
    }

    public function destroy(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        $delete = Ms_Rombel::where('id', $id)->delete();

        if ($delete) {
            return redirect(URL::to('data-rombel'))->with('success', 'Data berhasil dihapus.');
        }
    }

    public function index_admin()
    {
        $bentuk_pendidikan = Ms_DataSekolah::groupBy("bentuk_pendidikan")->whereIn('bentuk_pendidikan', ['TK','SD','SMP'])->get("bentuk_pendidikan");
        // $npsn = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', '226002')->pluck('npsn');

        $data = array();
        foreach ($bentuk_pendidikan as $bp) {
            $sekolah = Ms_DataSekolah::where('bentuk_pendidikan', $bp->bentuk_pendidikan)->get();
            foreach ($sekolah as $s) {
                $data[trim($s->kode_wilayah_induk_kecamatan)]['kode_wil'] = $s->kode_wilayah_induk_kecamatan;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['nama'] = $s->induk_kecamatan;
                $data[trim($s->kode_wilayah_induk_kecamatan)][$bp->bentuk_pendidikan] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['total'] = 0;


                $arnpsn[$s->npsn] = "'$s->npsn'";
                // dd($arnpsn);
                $list = implode(",", $arnpsn);

            }

        }

        $sql_count = "SELECT kode_wilayah_induk_kecamatan, bentuk_pendidikan, COUNT(r.sekolah_npsn)
        FROM ms_sekolah as s
        LEFT JOIN ms_rombel as r on r.sekolah_npsn = s.npsn
        WHERE s.bentuk_pendidikan IN ('TK','SD','SMP')
        GROUP BY  kode_wilayah_induk_kecamatan, bentuk_pendidikan
        ORDER BY kode_wilayah_induk_kecamatan ASC";

        $count = DB::select($sql_count);
        foreach ($count as $c) {
            $data[trim($c->kode_wilayah_induk_kecamatan)][$c->bentuk_pendidikan] += $c->count;
            $data[trim($c->kode_wilayah_induk_kecamatan)]['total'] += $data[trim($c->kode_wilayah_induk_kecamatan)][$c->bentuk_pendidikan];
        }

        return view('data-rombel.index_admin', compact('data'));
    }

    public function show_admin($idwil)
    {
        $idwil = Crypt::decrypt($idwil);

        $sql_hitung = "SELECT s.npsn, s.nama, s.bentuk_pendidikan, s.status_sekolah, COALESCE(count(r.*), 0) as tot
        FROM ms_sekolah as s
        LEFT JOIN ms_rombel as r on r.sekolah_npsn = s.npsn
        WHERE s.kode_wilayah_induk_kecamatan = '$idwil'
        GROUP BY s.npsn, s.nama, s.bentuk_pendidikan, s.status_sekolah";

        $query = DB::select($sql_hitung);

        // dd($query);
        $data_kec = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->first();
        return view('data-rombel.show_admin', compact('query', 'data_kec'));
    }

    public function detail_admin($npsn)
    {
        $rombel = Ms_Rombel::with('walikelas')->where('sekolah_npsn', $npsn)->get();
        $kelas = array();

        $sekolah = Ms_DataSekolah::where('npsn', $npsn)->first();

        // dd($npsn);
        $sql_count = "SELECT
        pd.rombel,
        SUM ( CASE WHEN pd.jk = 'L' THEN 1 ELSE 0 END ) as L,
        SUM ( CASE WHEN pd.jk = 'P' THEN 1 ELSE 0 END ) as P,
        COUNT (pd.nik) AS total
        FROM
        tr_pesertadidik AS pd
        WHERE pd.sekolah_npsn = '$npsn'
        GROUP BY pd.rombel";

        // dd($sql_count);
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

        return view('data-rombel.detail_admin', compact('kelas', 'sekolah'));
    }
}
