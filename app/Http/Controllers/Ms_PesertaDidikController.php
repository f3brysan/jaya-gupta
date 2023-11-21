<?php

namespace App\Http\Controllers;

use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Illuminate\Support\Facades\DB;
use App\Imports\PesertaDidikImport;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Exports\PesertaDidikTemplateExport;

class Ms_PesertaDidikController extends Controller
{
    public function index()
    {
        $data_peserta_didik = PesertaDidik::where('sekolah_npsn', auth()->user()->bio->asal_satuan_pendidikan)->orderBy('rombel')->orderBy('nama')->get();
        return view('data_peserta_didik.index', compact('data_peserta_didik'));
    }

    public function edit($id)
    {
        $bio = PesertaDidik::where('id', $id)->first();

        return view('data_peserta_didik.edit', compact('bio'));
    }

    public function store(Request $request)
    {
        $record = $request->all();
        $id = Crypt::decrypt($request->id);
        unset($record['_token']);
        unset($record['id']);

        $update = PesertaDidik::where('id', $id)->update($record);

        if ($update) {
            return redirect(URL::to('data-peserta-didik/edit/' . $id))->with('success', 'Data berhasil diperbaharui.');
        }
    }

    public function destroy(Request $request)
    {

        $id = Crypt::decrypt($request->id);
        $delete = PesertaDidik::where('id', $id)->delete();

        if ($delete) {
            return redirect(URL::to('data-peserta-didik'))->with('success', 'Data berhasil dihapus.');
        }
    }

    public function export_template()
    {
        return Excel::download(new PesertaDidikTemplateExport(), 'template_peserta_didik.xlsx');
    }

    public function import(Request $request)
    {
        error_reporting(0);
        // validasi
        $this->validate($request, [
            'dokumen' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('dokumen');

        // membuat nama file unik
        $nama_file = date("Y_m_d") . '_' . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('unggahan_excel', $nama_file);

        // import data
        $rows = Excel::toArray(new PesertaDidikImport, public_path('/unggahan_excel/' . $nama_file));


        $bin = PesertaDidik::get();
        $nik = $bin->pluck('nik');
        $new = 0;
        $updated = 0;
        foreach ($rows[0] as $row) {
            if ($nik->contains($row[7]) == false) {
                $exe = PesertaDidik::create([
                    'sekolah_npsn' => auth()->user()->bio->asal_satuan_pendidikan,
                    'nama' => $row[1],
                    'nipd' => $row[2],
                    'jk' => $row[3],
                    'nisn' => $row[4],
                    'tempatlahir' => $row[5],
                    // 'tanggal_lahir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])),
                    'tgllahir' => $row[6],
                    // 'tgllahir' => $date,
                    'nik' => $row[7],
                    'agama' => $row[8],
                    'alamat' => $row[9],
                    'hp' => $row[10],
                    'nama_ayah' => $row[11],
                    'pendidikan_ayah' => $row[12],
                    'pekerjaan_ayah' => $row[13],
                    'nama_ibu' => $row[14],
                    'pendidikan_ibu' => $row[15],
                    'pekerjaan_ibu' => $row[16],
                    'nama_wali' => $row[17],
                    'pendidikan_wali' => $row[18],
                    'pekerjaan_wali' => $row[19],
                    'rombel' => $row[20],
                    'kebutuhan_khusus' => $row[21],
                    'sekolah_asal' => $row[22],
                    'anak_ke' => $row[23],
                    'no_kk' => $row[24],
                    'bb' => $row[25],
                    'tb' => $row[26],
                    'lingkar_kepala' => $row[27],
                    'jml_saudara' => $row[28],
                    'jarak_sekolah' => $row[29],
                ]);

                $new += 1;
            } else {
                $exe = PesertaDidik::where('nik', $row[7])->update([
                    'sekolah_npsn' => auth()->user()->bio->asal_satuan_pendidikan,
                    'nama' => $row[1],
                    'nipd' => $row[2],
                    'jk' => $row[3],
                    'nisn' => $row[4],
                    'tempatlahir' => $row[5],
                    // 'tanggal_lahir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])),
                    'tgllahir' => $row[6],
                    // 'tgllahir' => $date,                    
                    'agama' => $row[8],
                    'alamat' => $row[9],
                    'hp' => $row[10],
                    'nama_ayah' => $row[11],
                    'pendidikan_ayah' => $row[12],
                    'pekerjaan_ayah' => $row[13],
                    'nama_ibu' => $row[14],
                    'pendidikan_ibu' => $row[15],
                    'pekerjaan_ibu' => $row[16],
                    'nama_wali' => $row[17],
                    'pendidikan_wali' => $row[18],
                    'pekerjaan_wali' => $row[19],
                    'rombel' => $row[20],
                    'kebutuhan_khusus' => $row[21],
                    'sekolah_asal' => $row[22],
                    'anak_ke' => $row[23],
                    'no_kk' => $row[24],
                    'bb' => $row[25],
                    'tb' => $row[26],
                    'lingkar_kepala' => $row[27],
                    'jml_saudara' => $row[28],
                    'jarak_sekolah' => $row[29],
                ]);
                $updated += 1;
            }

        }
        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // dd($import);
        return redirect(URL::to('data-peserta-didik'))->with('success', $new . ' data Baru. ' . $updated . ' data diperbaharui');
    }

    public function index_admin()
    {        
        $bentuk_pendidikan = Ms_DataSekolah::groupBy("bentuk_pendidikan")->get("bentuk_pendidikan");
        $npsn = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', '226002')->pluck('npsn');

        $data = array();
        foreach ($bentuk_pendidikan as $bp) {
            $sekolah = Ms_DataSekolah::where('bentuk_pendidikan', $bp->bentuk_pendidikan)->get();
            foreach ($sekolah as $s) {
                $data[trim($s->kode_wilayah_induk_kecamatan)]['kode_wil'] = $s->kode_wilayah_induk_kecamatan;                
                $data[trim($s->kode_wilayah_induk_kecamatan)]['nama'] = $s->induk_kecamatan;                
                $data[trim($s->kode_wilayah_induk_kecamatan)][$bp->bentuk_pendidikan.'_l'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)][$bp->bentuk_pendidikan.'_p'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)][$bp->bentuk_pendidikan] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['total'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['total_l'] = 0;
                $data[trim($s->kode_wilayah_induk_kecamatan)]['total_p'] = 0;


                $arnpsn[$s->npsn] = "'$s->npsn'";
                // dd($arnpsn);
                $list = implode(",", $arnpsn);                
                
            }

        }

        $sql_count = "SELECT
                s.bentuk_pendidikan,
                s.kode_wilayah_induk_kecamatan as kodewil,
                SUM ( CASE WHEN pd.jk = 'L' THEN 1 ELSE 0 END ) AS L,
                SUM ( CASE WHEN pd.jk = 'P' THEN 1 ELSE 0 END ) AS P,
                COUNT ( pd.nik ) AS total 
            FROM
                tr_pesertadidik AS pd 
                LEFT JOIN ms_sekolah as s on s.npsn = pd.sekolah_npsn
            WHERE
                s.npsn IN ($list) 
            GROUP BY
            s.bentuk_pendidikan, s.kode_wilayah_induk_kecamatan";

                $hitung_siswa = DB::select($sql_count);
                if (count($hitung_siswa) > 0) {
                    foreach ($hitung_siswa as $item) {
                        $data[trim($item->kodewil)][$item->bentuk_pendidikan.'_l'] += $item->l;
                        $data[trim($item->kodewil)][$item->bentuk_pendidikan.'_p'] += $item->p;
                        $data[trim($item->kodewil)][$item->bentuk_pendidikan] += $item->p+$item->l;
                        $data[trim($item->kodewil)]['total'] += $data[trim($item->kodewil)][$item->bentuk_pendidikan];
                        $data[trim($item->kodewil)]['total_l'] += $data[trim($item->kodewil)][$item->bentuk_pendidikan.'_l'];
                        $data[trim($item->kodewil)]['total_p'] += $data[trim($item->kodewil)][$item->bentuk_pendidikan.'_p'];
                    }
                }                
        return view('data_peserta_didik.index_admin', compact('data'));
    }

    public function detail_sekolah_admin($idwil)
    {
        $idwil = Crypt::decrypt($idwil);      
        
        $data_kec = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->first();

        $sql_pd = "SELECT s.npsn, s.nama, s.bentuk_pendidikan, s.status_sekolah, COALESCE(pdl.l, 0) AS tot_l, COALESCE(pdp.p, 0) as tot_p
        FROM ms_sekolah as s
        LEFT JOIN (SELECT sekolah_npsn, COUNT(*) as l FROM tr_pesertadidik WHERE UPPER(jk) = 'L' GROUP BY sekolah_npsn) AS pdl on pdl.sekolah_npsn = s.npsn
        LEFT JOIN (SELECT sekolah_npsn, COUNT(*) as p FROM tr_pesertadidik WHERE UPPER(jk) = 'P' GROUP BY sekolah_npsn) AS pdp on pdp.sekolah_npsn = s.npsn
        WHERE s.kode_wilayah_induk_kecamatan = '$idwil'
        ORDER BY s.nama";
        $data_pd = DB::select($sql_pd);        

        return view('data_peserta_didik.show_admin', compact('data_pd', 'data_kec'));
    }

    public function detail_pd_admin($npsn)
    {
        $data_peserta_didik = PesertaDidik::where('sekolah_npsn', $npsn)->orderBy('rombel')->orderBy('nama')->get();
        return view('data_peserta_didik.detail_admin', compact('data_peserta_didik'));
    }
}
