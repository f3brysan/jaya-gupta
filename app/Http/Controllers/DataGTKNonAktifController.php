<?php

namespace App\Http\Controllers;

use App\Models\Ms_JenjangPendidikanDikti;
use App\Models\Ms_Pangkat;
use App\Models\User;
use App\Models\Biodata;
use App\Models\Regency;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class DataGTKNonAktifController extends Controller
{
    public function index()
    {
        $user_guru = User::role('nonaktif')->pluck('id');

        $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', auth()->user()->bio->asal_satuan_pendidikan)->get();

        return view('data-gtk-nonaktif.index', compact('getData'));
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
        return view('data-gtk-nonaktif.edit', $data);
    }

    public function update(Request $request)
    {
        $id = Crypt::decrypt($request->id);        
        $nama = $request->gelar_depan . ' ' . $request->nama_lengkap . ' ' . $request->gelar_blkg;
        
        DB::beginTransaction();
        
        $user = User::where('id', $id)->update([
            'name' => $nama,
            'email' => $request->email,
            'nuptk' => $request->nuptk
        ]);

        if ($request->file('image')) {
            $path =$request->file('image')->store('/images/profile', ['disk' =>   'my_files']);
        }else{
            $check = Biodata::where('id', $id)->first();
            if ($check) {
                $path = $check->profile_picture;
            } else {
                $path = NULL;
            }                    
        }

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
            'profile_picture' => $path
        ]);
        
        
        if ($bio) {
            DB::commit();
            return redirect('data-gtk-nonaktif')->with('success', 'Data berhasil disimpan.');
        } else {
            DB::rollBack();
            return redirect('data-gtk-nonaktif/ubah/'.$id)->with('error', 'Data gagal disimpan.');
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
