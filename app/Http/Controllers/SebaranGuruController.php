<?php

namespace App\Http\Controllers;

use App\Models\Ms_DataSekolah;
use Illuminate\Http\Request;
use App\Models\Ms_MataPelajaran;
use Illuminate\Support\Facades\DB;

class SebaranGuruController extends Controller
{
    public function index($bentuk_pendidikan)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        $mapel = Ms_MataPelajaran::where('jenjang', $bentuk_pendidikan)->get();
        return view('rekap.sebaran-guru.index', compact('bentuk_pendidikan', 'mapel'));
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

    public function guru_mapel($bentuk_pendidikan, $mapel)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        
        $mata_pelajaran = Ms_MataPelajaran::where('jenjang', $bentuk_pendidikan)->where('nama', $mapel)->first();
        $mapel = strtoupper($mapel);
        $sql = "SELECT
	s.status_sekolah,
	COUNT ( DISTINCT ( r.ID ) ) AS tot_rombel,
	COUNT ( DISTINCT pns.* ) AS tot_pns,
	COUNT ( DISTINCT pppk.* ) AS tot_pppk,
	COUNT ( DISTINCT kd.* ) AS tot_kd,
	COUNT ( DISTINCT hs.* ) AS tot_hs
FROM
	ms_sekolah AS s
	LEFT OUTER JOIN ms_rombel AS r ON r.sekolah_npsn = s.npsn
	LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE UPPER(mengajar) = '$mapel' AND status_kepegawaian = 'PNS' ) AS pns ON pns.asal_satuan_pendidikan = s.npsn
	LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE UPPER(mengajar) = '$mapel' AND status_kepegawaian = 'PPPK' ) AS pppk ON pns.asal_satuan_pendidikan = s.npsn
	LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE UPPER(mengajar) = '$mapel' AND UPPER ( status_kepegawaian ) LIKE'%DAERAH%' ) AS kd ON pns.asal_satuan_pendidikan = s.npsn
	LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE UPPER(mengajar) = '$mapel' AND UPPER ( status_kepegawaian ) LIKE'%HONOR SEKOLAH%' ) AS hs ON pns.asal_satuan_pendidikan = s.npsn 
WHERE
	s.bentuk_pendidikan = '$bentuk_pendidikan' 
GROUP BY
	s.status_sekolah";
        $getData = DB::select($sql);

        return view('rekap.sebaran-guru.guru-mapel.index', compact('getData', 'bentuk_pendidikan', 'mata_pelajaran'));
    }

    public function guru_mapel_sekolah($bentuk_pendidikan, $mapel, $status_sekolah)
    {
        $bentuk_pendidikan = strtoupper($bentuk_pendidikan);
        $mata_pelajaran = Ms_MataPelajaran::where('jenjang', $bentuk_pendidikan)->where('nama', $mapel)->first();
        
        $sql = "SELECT
        s.nama,
        s.npsn,
        COUNT ( DISTINCT ( r.ID ) ) AS tot_rombel,
        COUNT ( DISTINCT pns.* ) AS tot_pns,
        COUNT ( DISTINCT pppk.* ) AS tot_pppk,
        COUNT ( DISTINCT kd.* ) AS tot_kd,
        COUNT ( DISTINCT hs.* ) AS tot_hs
    FROM
        ms_sekolah AS s
        LEFT OUTER JOIN ms_rombel AS r ON r.sekolah_npsn = s.npsn
        LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE mengajar = '$mapel' AND status_kepegawaian = 'PNS' ) AS pns ON pns.asal_satuan_pendidikan = s.npsn
        LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE mengajar = '$mapel' AND status_kepegawaian = 'PPPK' ) AS pppk ON pns.asal_satuan_pendidikan = s.npsn
        LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE mengajar = '$mapel' AND UPPER ( status_kepegawaian ) LIKE'%DAERAH%' ) AS kd ON pns.asal_satuan_pendidikan = s.npsn
        LEFT JOIN ( SELECT * FROM ms_biodatauser WHERE mengajar = '$mapel' AND UPPER ( status_kepegawaian ) LIKE'%HONOR SEKOLAH%' ) AS hs ON pns.asal_satuan_pendidikan = s.npsn 
    WHERE
        s.bentuk_pendidikan = '$bentuk_pendidikan' AND s.status_sekolah = '$status_sekolah'
    GROUP BY
        s.nama, s.npsn";

        $getData = DB::select($sql);

        return view('rekap.sebaran-guru.guru-mapel.guru_sekolah', compact('bentuk_pendidikan', 'status_sekolah', 'getData', 'mata_pelajaran'));
    }

    public function detil_guru_mapel_sekolah($npsn, $mapel)
    {
        $sekolah = Ms_DataSekolah::where('npsn', $npsn)->first();
        $mata_pelajaran = Ms_MataPelajaran::where('jenjang', $sekolah->bentuk_pendidikan)->where('nama', $mapel)->first();
        $sql = "SELECT
        *,
    CASE            
            WHEN status_kepegawaian = 'PNS' THEN
            'ASN' 
            WHEN status_kepegawaian = 'PPPK' THEN
            'ASN' ELSE'NON ASN' 
        END AS status_pns 
    FROM
        ms_biodatauser 
    WHERE
        mengajar = '$mapel' 
        AND asal_satuan_pendidikan = '$npsn'";
        $dataGuruKelas = DB::select($sql);

        return view('rekap.sebaran-guru.guru-mapel.detil_guru_sekolah', compact('sekolah', 'dataGuruKelas', 'mata_pelajaran'));
    }
}
