<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Regency;
use App\Models\Province;
use App\Models\Ms_Pangkat;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use App\Imports\DataGuruImport;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Exports\DataGuruTemplateExport;
use App\Models\Ms_JenjangPendidikanDikti;

class DataGuruController extends Controller
{
    public function index()
    {
        $user_guru = User::role('guru')->pluck('id');
        if (auth()->user()->hasRole('superadmin')) {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->get();
        } else {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', auth()->user()->bio->asal_satuan_pendidikan)->get();
        }

        return view('data-guru.index', compact('getData'));
    }

    public function create()
    {
        $data['asal_satuan'] = Ms_DataSekolah::orderBy('kode_wilayah_induk_kecamatan', 'ASC')->orderBy('created_at', 'ASC')->get();
        $data['kab'] = Regency::all();
        $data['prov'] = Province::all();
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        return view('data-guru.create', $data);
    }

    public function store(Request $request)
    {
        $nama = $request->gelardepan . ' ' . $request->nama_lengkap . ' ' . $request->gelar_blkg;
        $date = strtotime($request->tgllahir);
        $password = date('d', $date) . date("m", $date) . date("Y", $date);
        // dd($request->all());

        DB::beginTransaction();
        // * check email apakah sudah ada?
        $check_user = User::where('email', $request->email)->first();

        if (empty($check_user)) {
            // create user
            $user = User::create([
                'name' => $nama,
                'email' => $request->email,
                'password' => bcrypt($password),
                'nuptk' => $request->nuptk
            ]);
            // tambah role
            $user->assignRole('guru');
        }

        $biodata = Biodata::create([
            'id' => $user->id,
            'nama' => $nama,
            'nama_lengkap' => $request->nama_lengkap,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_blkg,
            'nuptk' => $request->nuptk,
            'tempatlahir' => $request->tempatlahir,
            'tanggallahir' => $request->tgllahir,
            'provdom' => $request->provdom,
            'kabdom' => $request->kabdom,
            'kecdom' => $request->kecdom,
            'keldom' => $request->keldom,
            'alamatdom' => $request->desadom,
            'kodepos' => $request->kodepos,
            'telepon' => $request->telepon,
            'wa' => $request->wa,
            'nip' => $request->nip,
            'golongan' => $request->golongan,
            'status_kepegawaian' => $request->status_kepegawaian,
            'pendidikan_terakhir' => $request->jenjang,
            'mengajar' => $request->mengajar,
            'prodi' => $request->jurusan,
            'sertifikasi' => $request->sertifikasi,
            'tugas_tambahan' => $request->tugas_tambahan,
            'sk_cpns' => $request->sk_cpns,
            'tgl_cpns' => $request->tgl_cpns,
            'sk_pengangkatan' => $request->sk_pengangkatan,
            'tmt_pengangkatan' => $request->tmt_pengangkatan,
            'sumber_gaji' => $request->sumber_gaji,
            'nm_ibu' => $request->nm_ibu,
            'status_perkawinan' => $request->status_perkawinan,
            'nm_pasangan' => $request->nm_pasangan,
            'nip_pasangan' => $request->nip_pasangan,
            'pekerjaan_pasangan' => $request->pekerjaan_pasangan,
            'tmt_pns' => $request->tmt_pns,
            'npwp' => $request->npwp,
            'bank' => $request->bank,
            'norek_bank' => $request->norek_bank,
            'nama_norek' => $request->nama_norek,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'is_penggerak' => $request->is_penggerak,
            'jam_tgs_tambahan' => $request->jam_tgs_tambahan,
            'jjm' => $request->jjm,
            'siswa' => $request->siswa,
            'status_sekolah' => $request->status_sekolah,
            'gender' => $request->gender,
            'asal_satuan_pendidikan' => $request->asal_satuan,
            'is_active' => 1,
            'lembaga_pengangkatan' => $request->lembaga_pengangkatan,
        ]);

        if ($biodata) {
            DB::commit();
            return redirect('data-guru')->with('success', 'Data berhasil disimpan.');
        } else {
            DB::rollBack();
            return redirect('data-guru/tambah/')->with('error', 'Data gagal disimpan.');
        }

    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        $data['get'] = Biodata::with('user')->find($id);
        $data['asal_satuan'] = Ms_DataSekolah::orderBy('kode_wilayah_induk_kecamatan', 'ASC')->orderBy('created_at', 'ASC')->get();
        $data['kab'] = Regency::all();
        $data['prov'] = Province::all();
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        $data['jenjang'] = Ms_JenjangPendidikanDikti::all();
        // return $data['getData'];
        return view('data-guru.edit', $data);

    }

    public function update(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $nama = $request->gelardepan . ' ' . $request->nama_lengkap . ' ' . $request->gelar_blkg;
        DB::beginTransaction();
        $user = User::where('id', $id)->update([
            'name' => $nama,
            'email' => $request->email,
            'nuptk' => $request->nuptk
        ]);
        $bio = Biodata::where('id', $id)->update([
            'nama' => $nama,
            'nama_lengkap' => $request->nama_lengkap,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_blkg,
            'nuptk' => $request->nuptk,
            'tempatlahir' => $request->tempatlahir,
            'tanggallahir' => $request->tgllahir,
            'provdom' => $request->provdom,
            'kabdom' => $request->kabdom,
            'kecdom' => $request->kecdom,
            'keldom' => $request->keldom,
            'alamatdom' => $request->desadom,
            'kodepos' => $request->kodepos,
            'telepon' => $request->telepon,
            'wa' => $request->wa,
            'nip' => $request->nip,
            'golongan' => $request->golongan,
            'status_kepegawaian' => $request->status_kepegawaian,
            'pendidikan_terakhir' => $request->jenjang,
            'mengajar' => $request->mengajar,
            'prodi' => $request->jurusan,
            'sertifikasi' => $request->sertifikasi,
            'tugas_tambahan' => $request->tugas_tambahan,
            'sk_cpns' => $request->sk_cpns,
            'tgl_cpns' => $request->tgl_cpns,
            'sk_pengangkatan' => $request->sk_pengangkatan,
            'tmt_pengangkatan' => $request->tmt_pengangkatan,
            'sumber_gaji' => $request->sumber_gaji,
            'nm_ibu' => $request->nm_ibu,
            'status_perkawinan' => $request->status_perkawinan,
            'nm_pasangan' => $request->nm_pasangan,
            'nip_pasangan' => $request->nip_pasangan,
            'pekerjaan_pasangan' => $request->pekerjaan_pasangan,
            'tmt_pns' => $request->tmt_pns,
            'npwp' => $request->npwp,
            'bank' => $request->bank,
            'norek_bank' => $request->norek_bank,
            'nama_norek' => $request->nama_norek,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'is_penggerak' => $request->is_penggerak,
            'jam_tgs_tambahan' => $request->jam_tgs_tambahan,
            'jjm' => $request->jjm,
            'total_jjm' => $request->jjm + $request->jam_tgs_tambahan,
            'siswa' => $request->siswa,
            'status_sekolah' => $request->status_sekolah,
            'gender' => $request->gender,
            'asal_satuan_pendidikan' => $request->asal_satuan,
            'lembaga_pengangkatan' => $request->lembaga_pengangkatan,
        ]);



        if ($bio) {
            DB::commit();
            return redirect('data-guru')->with('success', 'Data berhasil disimpan.');
        } else {
            DB::rollBack();
            return redirect('data-guru/edit/')->with('error', 'Data gagal disimpan.');
        }

    }

    public function export_template()
    {
        return Excel::download(new DataGuruTemplateExport(), 'template_data_guru.xlsx');
    }

    public function import(Request $request)
    {
        // error_reporting(0);
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
        $rows = Excel::toArray(new DataGuruImport, public_path('/unggahan_excel/' . $nama_file));


        $bin = Biodata::get();
        $nik = $bin->pluck('nik');

        $users = User::get();
        $email = $users->pluck('email');

        $new = 0;
        $updated = 0;

        DB::beginTransaction();

        foreach ($rows[0] as $row) {
            // * check email apakah sudah ada?
            if ($email->contains($row[20]) == false) {
                // buat password dari tgl lahir
                if ($row[5] == NULL) {
                    $password = '123456';
                } else {
                    $date = strtotime($row[5]);
                    $password = date('d', $date) . date("m", $date) . date("Y", $date);
                }
                $nama = $row[9] . ' ' . $row[1] . ' ' . $row[10];

                $createUser = User::create([
                    'email' => $row[20],
                    'name' => $nama,
                    'password' => bcrypt($password),
                    'nuptk' => $row[2]
                ]);

                $createUser->assignRole('guru');

                $createBio = Biodata::create([
                    'id' => $createUser->id,
                    'nama' => $nama,
                    'nama_lengkap' => $row[1],
                    'gelar_depan' => $row[9],
                    'gelar_belakang' => $row[10],
                    'nuptk' => $row[2],
                    'tempatlahir' => $row[4],
                    'tanggallahir' => $row[5],
                    'kecdom' => $row[16],
                    'keldom' => $row[15],
                    'alamatdom' => $row[14],
                    'kodepos' => $row[17],
                    'telepon' => $row[18],
                    'wa' => $row[19],
                    'nip' => $row[6],
                    'golongan' => $row[27],
                    'status_kepegawaian' => $row[7],
                    'pendidikan_terakhir' => $row[11],
                    'mengajar' => $row[8],
                    'prodi' => $row[12],
                    'sertifikasi' => $row[13],
                    'tugas_tambahan' => $row[21],
                    'sk_cpns' => $row[22],
                    'tgl_cpns' => $row[23],
                    'sk_pengangkatan' => $row[24],
                    'tmt_pengangkatan' => $row[25],
                    'sumber_gaji' => $row[28],
                    'nm_ibu' => $row[29],
                    'status_perkawinan' => $row[30],
                    'nm_pasangan' => $row[31],
                    'nip_pasangan' => $row[32],
                    'pekerjaan_pasangan' => $row[33],
                    'tmt_pns' => $row[34],
                    'npwp' => $row[35],
                    'bank' => $row[36],
                    'norek_bank' => $row[37],
                    'nama_norek' => $row[38],
                    'nik' => $row[39],
                    'no_kk' => $row[40],
                    'is_penggerak' => $row[41],
                    'jam_tgs_tambahan' => $row[42],
                    'jjm' => $row[43],
                    'total_jjm' => $row[44],
                    'siswa' => $row[45],
                    'status_sekolah' => $row[46],
                    'gender' => $request->gender,
                    'asal_satuan_pendidikan' => auth()->user()->bio->asal_satuan_pendidikan,
                    'is_active' => 1,
                    'lembaga_pengangkatan' => $row[26],
                ]);                

                $asal_sekolah = Ms_DataSekolah::where('npsn', auth()->user()->bio->asal_satuan_pendidikan)->first();

                // ! POST KE API SYNC HALO GURU
                // if ($createBio) {
                //     $send = Http::withHeaders([
                //         'client_secret' => 'haloguru_secretkey',
                //     ])->post('http://103.242.124.108:3033/sync-users', [
                //                 'id' => $createUser->id,
                //                 'email' => $createUser->email,
                //                 'name' => $nama,
                //                 'password' => $password,
                //                 'roleId' => 'gtk',
                //                 'foto' => null,
                //                 'biografi' => null,
                //                 'firebase_token' => null,
                //                 'gtk' => [
                //                     'nip_nuptk' => $row[2],
                //                     'mata_pelajaran' => null,
                //                     'media_pembelajaran' => [],
                //                     'pangkat' => $row[7],
                //                     'golongan' => $row[27],
                //                     'jabatan' => null,
                //                     'unit_kerja' => $asal_sekolah->nama,
                //                     'riwayat_pendidikan' => $row[12]
                //                 ]
                //             ]);
                // }
            }
        }
        // dd($send);
        if ($createBio) {
            DB::commit();
            return redirect('data-guru')->with('success', 'Data berhasil disimpan.');
        } else {
            DB::rollBack();
            return redirect('data-guru')->with('error', 'Data gagal disimpan.');
        }
    }

    public function destroy(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        DB::beginTransaction();
        $user = User::where('id', $id)->first();
        $user->removeRole('guru');
        $user->assignRole('nonaktif');

        $delete = Biodata::where('id', $id)->update([
            'is_active' => 0
        ]);


        if ($delete) {
            DB::commit();
            return redirect(URL::to('data-guru'))->with('success', 'Data berhasil dihapus.');
        }
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
        })->role('guru')->get('id');



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

        return view('data-guru.index_admin', compact('data'));
    }

    public function show_admin($idwil)
    {
        $idwil = Crypt::decrypt($idwil);
        $data_kec = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->first();
        $sekolah = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->pluck('npsn');
        $data_sekolah = Ms_DataSekolah::where('kode_wilayah_induk_kecamatan', $idwil)->get();
        $id_guru = User::with('bio')->whereHas('bio', function ($q) use ($sekolah) {
            $q->whereIn('asal_satuan_pendidikan', $sekolah);
        })->role('guru')->get('id');

        foreach ($id_guru as $id) {
            $arnpsn[$id->id] = "'$id->id'";
            // dd($arnpsn);
            $list = implode(",", $arnpsn);
        }

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
            // $data[$q->npsn]['total'] = $q->tot;
        }
        //    dd($data);
        return view('data-guru.show_admin', compact('data', 'data_kec'));
    }

    public function detail_admin($npsn)
    {
        $sekolah = Ms_DataSekolah::where('npsn', $npsn)->first();
        $user_guru = User::role('guru')->pluck('id');
        $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', $npsn)->get();

        return view('data-guru.detail_admin', compact('getData', 'sekolah'));
    }
}
