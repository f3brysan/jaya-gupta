<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class DataGTKNonAktifController extends Controller
{
    public function index()
    {
        $user_guru = User::role('nonaktif')->pluck('id');
        if (auth()->user()->hasRole('superadmin')) {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->get();
        } else {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', auth()->user()->bio->asal_satuan_pendidikan)->get();
        }

        return view('data-gtk-nonaktif.index', compact('getData'));
    }

    public function index_admin()
    {
        $bentuk_pendidikan = Ms_DataSekolah::groupBy("bentuk_pendidikan")->get("bentuk_pendidikan");
        $arrnpsn = Ms_DataSekolah::get()->pluck('npsn');

        $data = array();
        foreach ($bentuk_pendidikan as $bp) {
            $sekolah = Ms_DataSekolah::where('bentuk_pendidikan', $bp->bentuk_pendidikan)->get();
            foreach ($sekolah as $s) {
                $data[trim($s->kode_wilayah_induk_kecamatan)]['kode_wil'] = $s->kode_wilayah_induk_kecamatan;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['nama'] = $s->induk_kecamatan;
                $data[trim($s->kode_wilayah_induk_kecamatan)][$bp->bentuk_pendidikan . '_l'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)][$bp->bentuk_pendidikan . '_p'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)][$bp->bentuk_pendidikan] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['total'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['total_l'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['total_p'] = 0;

            }
        }

        // dd($arrnpsn);

        $id_guru = User::with('bio')->whereHas('bio', function ($q) use ($arrnpsn) {
            $q->whereIn('asal_satuan_pendidikan', $arrnpsn);
        })->role('nonaktif')->get('id');

        if (count($id_guru) > 0) {
            foreach ($id_guru as $id) {
                $arnpsn[$id->id] = "'$id->id'";
                // dd($arnpsn);
                $list = implode(",", $arnpsn);
            }


            $sql_count = "SELECT
            s.kode_wilayah_induk_kecamatan, s.bentuk_pendidikan, 
            SUM ( CASE WHEN UPPER ( u.gender ) = 'L' THEN 1 ELSE 0 END ) AS laki,
            SUM ( CASE WHEN UPPER ( u.gender ) = 'W' THEN 1 ELSE 0 END ) AS perempuan,
            SUM ( CASE WHEN UPPER ( u.gender ) IS NULL THEN 1 ELSE 0 END ) AS unknown
            FROM
           ms_biodatauser AS u 
           LEFT JOIN ms_sekolah as s on s.npsn = u.asal_satuan_pendidikan
            WHERE
           u.id IN ($list)       
           GROUP BY s.kode_wilayah_induk_kecamatan, s.bentuk_pendidikan";
            $query = DB::select($sql_count);

            foreach ($query as $q) {
                $data[trim($q->kode_wilayah_induk_kecamatan)][$q->bentuk_pendidikan . '_l'] += $q->laki;
                $data[trim($q->kode_wilayah_induk_kecamatan)][$q->bentuk_pendidikan . '_p'] += $q->perempuan;
                $data[trim($q->kode_wilayah_induk_kecamatan)]['total_l'] += $data[trim($q->kode_wilayah_induk_kecamatan)][$q->bentuk_pendidikan . '_l'];
                $data[trim($q->kode_wilayah_induk_kecamatan)]['total_p'] += $data[trim($q->kode_wilayah_induk_kecamatan)][$q->bentuk_pendidikan . '_p'];
                $data[trim($q->kode_wilayah_induk_kecamatan)]['total'] += $data[trim($q->kode_wilayah_induk_kecamatan)][$q->bentuk_pendidikan . '_p'] + $data[trim($q->kode_wilayah_induk_kecamatan)][$q->bentuk_pendidikan . '_l'];
            }
        }

        return view('data-gtk-nonaktif.index_admin', compact('data'));
    }

    public function show_admin($idwil)
    {
        $idwil = Crypt::decrypt($idwil);
        $data_kec = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->first();
        $sekolah = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->pluck('npsn');
        $data_sekolah = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->get();
        $id_guru = User::with('bio')->whereHas('bio', function ($q) use ($sekolah) {
            $q->whereIn('asal_satuan_pendidikan', $sekolah);
        })->role('nonaktif')->get('id');

        $data = array();
        foreach ($data_sekolah as $s) {
            $data[$s->npsn]['npsn'] = $s->npsn;
            $data[$s->npsn]['nama'] = $s->nama;
            $data[$s->npsn]['bentuk_pendidikan'] = $s->bentuk_pendidikan;
            $data[$s->npsn]['status_sekolah'] = $s->status_sekolah;
            $data[$s->npsn]['total_l'] = 0;
            $data[$s->npsn]['total_p'] = 0;
            $data[$s->npsn]['total'] = 0;
        }

        if (count($id_guru) > 0) {
            foreach ($id_guru as $id) {
                $arnpsn[$id->id] = "'$id->id'";
                // dd($arnpsn);
                $list = implode(",", $arnpsn);
            }
            $sql_count = "SELECT
        s.npsn, 
        SUM ( CASE WHEN UPPER ( u.gender ) = 'L' THEN 1 ELSE 0 END ) AS laki,
        SUM ( CASE WHEN UPPER ( u.gender ) = 'W' THEN 1 ELSE 0 END ) AS perempuan,
        SUM ( CASE WHEN UPPER ( u.gender ) IS NULL THEN 1 ELSE 0 END ) AS unknown,
        COUNT(u.*) as tot
   FROM
       ms_biodatauser AS u 
       RIGHT JOIN ms_sekolah as s on s.npsn = u.asal_satuan_pendidikan
   WHERE
       u.id IN ($list)
       GROUP BY  s.npsn";

            $query = DB::select($sql_count);

            foreach ($query as $q) {
                $data[$q->npsn]['total_l'] = $q->laki;
                $data[$q->npsn]['total_p'] = $q->perempuan;                
            }
        }
        return view('data-gtk-nonaktif.show_admin', compact('data', 'data_kec'));
    }

    public function detail_admin($npsn)
    {
        $sekolah = Ms_DataSekolah::where('npsn', $npsn)->first();
        $user_guru = User::role('nonaktif')->pluck('id');
        $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', $npsn)->get();

        return view('data-gtk-nonaktif.detail_admin', compact('getData', 'sekolah'));
    }
}
