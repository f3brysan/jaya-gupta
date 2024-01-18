<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Illuminate\Support\Facades\DB;

class SebaranGuruKelasController extends Controller
{
    public function index($bentuk_pendidikan)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        return view('rekap.sebaran-guru.index', compact('bentuk_pendidikan'));
    }

    public function guru_kelas($bentuk_pendidikan)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        $sql = "SELECT s.status_sekolah, COUNT(DISTINCT(r.id)) as tot_rombel, COUNT(DISTINCT(b.id)) as guru_kelas
        FROM ms_sekolah as s
        LEFT JOIN ms_rombel as r on r.sekolah_npsn = s.npsn
        LEFT JOIN ms_biodatauser as b on b.asal_satuan_pendidikan = s.npsn AND LOWER(b.mengajar) LIKE '%kelas%'
        WHERE s.bentuk_pendidikan = '$bentuk_pendidikan'
        GROUP BY s.status_sekolah";
        $getData = DB::select($sql);

        return view('rekap.sebaran-guru.guru-kelas.index', compact('getData', 'bentuk_pendidikan'));
    }

    public function rombel_sekolah($bentuk_pendidikan, $status_sekolah)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        $sql = "SELECT
                s.npsn,
                s.nama,
            COUNT ( DISTINCT ( r.ID ) ) AS tot_rombel    
        FROM ms_sekolah as s
        LEFT JOIN ms_rombel as r on r.sekolah_npsn = s.npsn    
        WHERE s.bentuk_pendidikan = '$bentuk_pendidikan'
        AND s.status_sekolah = '$status_sekolah'
        GROUP BY s.npsn, s.nama
        ORDER BY s.npsn ASC";
        $getData = DB::select($sql);

        return view('rekap.sebaran-guru.guru-kelas.rombel', compact('getData', 'bentuk_pendidikan', 'status_sekolah'));
    }

    public function guru_kelas_sekolah($bentuk_pendidikan, $status_sekolah)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        $sql = "SELECT
        s.npsn,
        s.nama,
        COUNT ( DISTINCT ( b.ID ) ) AS guru_kelas 
    FROM
        ms_sekolah AS s
        LEFT JOIN ms_biodatauser AS b ON b.asal_satuan_pendidikan = s.npsn AND lower(b.mengajar) like '%kelas%'
        WHERE s.bentuk_pendidikan = '$bentuk_pendidikan' 
        AND s.status_sekolah = '$status_sekolah' 
    GROUP BY
        s.npsn,
        s.nama";

        $getData = DB::select($sql);

        return view('rekap.sebaran-guru.guru-kelas.guru_sekolah', compact('bentuk_pendidikan', 'status_sekolah', 'getData'));
    }

    public function detil_guru_kelas_sekolah($npsn)
    {
        $sekolah = Ms_DataSekolah::where('npsn', $npsn)->first();
        $sql = "SELECT *, CASE 
        WHEN nip is not null or tgl_cpns is not null THEN
            'ASN'
        ELSE
            'NON ASN'
    END AS status_pns
    FROM ms_biodatauser
    WHERE LOWER(mengajar) like '%kelas%'
    AND asal_satuan_pendidikan = '$npsn'";
        $dataGuruKelas = DB::select($sql);

        return view('rekap.sebaran-guru.guru-kelas.detil_guru_sekolah', compact('sekolah', 'dataGuruKelas'));
    }

    public function kurang_guru($bentuk_pendidikan, $status_sekolah)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        $sql = "SELECT m.npsn, m.nama, m.tot_rombel - m.guru_kelas AS MARGIN
                FROM (
                SELECT
                    s.npsn,
                    s.nama,
                    COUNT ( DISTINCT ( r.ID ) ) AS tot_rombel,
                    COUNT ( DISTINCT ( b.ID ) ) AS guru_kelas
                FROM ms_sekolah as s
                LEFT JOIN ms_rombel as r on r.sekolah_npsn = s.npsn
                LEFT JOIN ms_biodatauser as b on b.asal_satuan_pendidikan = s.npsn AND LOWER(b.mengajar) LIKE '%kelas%'
                WHERE s.bentuk_pendidikan = '$bentuk_pendidikan'
                AND s.status_sekolah = '$status_sekolah'
                GROUP BY s.npsn, s.nama ) AS m
                GROUP BY  m.npsn, m.nama, m.tot_rombel, m.guru_kelas
                HAVING m.tot_rombel - m.guru_kelas > '0'";
        $getData = DB::select($sql);

        return view('rekap.sebaran-guru.guru-kelas.kurang_guru', compact('bentuk_pendidikan', 'status_sekolah', 'getData'));
    }
}
