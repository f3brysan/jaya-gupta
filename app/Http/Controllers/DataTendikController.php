<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Ms_Pangkat;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use App\Imports\DataGuruImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Exports\DataGuruTemplateExport;
use App\Models\Ms_JenjangPendidikanDikti;

class DataTendikController extends Controller
{
    public function index()
    {
        $user_guru = User::role('tendik')->pluck('id');
        if (auth()->user()->hasRole('superadmin')) {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->get();
        } else {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', auth()->user()->bio->asal_satuan_pendidikan)->get();
        }

        return view('data-tendik.index', compact('getData'));
    }

    public function export_template()
    {
        return Excel::download(new DataGuruTemplateExport(), 'template_data_tendik.xlsx');
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
        // dd($rows);
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

                $createUser->assignRole('tendik');

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
            }
        }

        if ($createBio) {
            DB::commit();
            return redirect('data-tendik')->with('success', 'Data berhasil disimpan.');
        } else {
            DB::rollBack();
            return redirect('data-tendik')->with('error', 'Data gagal disimpan.');
        }
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        $data['get'] = Biodata::with('user')->find($id);
        $data['asal_satuan'] = Ms_DataSekolah::orderBy('kode_wilayah_induk_kecamatan', 'ASC')->orderBy('created_at', 'ASC')->get();       
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        $data['jenjang'] = Ms_JenjangPendidikanDikti::all();
        // return $data['getData'];
        return view('data-tendik.edit', $data);

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
    public function destroy(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        
        DB::beginTransaction();       
            $user = User::where('id', $id)->first();
            $user->removeRole('tendik');
            $user->assignRole('nonaktif');

            $delete = Biodata::where('id', $id)->update([
                'is_active' => 0
            ]);
        

        if ($delete) {
            DB::commit();
            return redirect(URL::to('data-tendik'))->with('success', 'Data berhasil dihapus.');
        }
    }
}
