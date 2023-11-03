<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Regency;
use App\Models\Province;
use App\Models\Ms_Pangkat;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use App\Models\Ms_JenjangPendidikanDikti;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;

class DataGuruController extends Controller
{
    public function index(Request $request)
    {
        $user_guru = User::role('guru')->pluck('id');
        if (auth()->user()->hasRole('superadmin')) {
            $getData = Biodata::with('user','user.roles','asal_sekolah','user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->get();
        } else {
            $getData = Biodata::with('user','user.roles','asal_sekolah','user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', auth()->user()->bio->asal_satuan_pendidikan)->get();
        }
                
        // return $getData->where('id','1');
        if ($request -> ajax()) {
            return DataTables::of($getData)
            ->addColumn('asal_sekolah', function($getData){
                $asal_sekolah = $getData->asal_sekolah->nama ?? '';
                return $asal_sekolah;
            })
            ->addColumn('role', function($getData){                
                $result = '';
                foreach ($getData->user->roles as $role) {
                    $result .= '<li>'.$role->name.'</li>';
                }
                return $result;
            })    
            ->addColumn('email', function($getData){
                return $getData->user->email;
            })
            ->addColumn('bidang_pengembangan', function($getData){
                $value = "";
                if (count($getData->user_bidang_pengembangan)>0) {
                    foreach ($getData->user_bidang_pengembangan as $item) {
                        $value .= '<li>'.$item->bidangpengembangan->nama.'</li>'; 
                    }
                    $value .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Hapus" class="btn btn-warning btn-sm float-right"><i class="fas fa-wrench"></i></a>';
                } else {
                    $value = 'Belum Ada Data.';
                    $value .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Hapus" class="btn btn-warning btn-sm float-right"><i class="fas fa-wrench"></i></a>';
                }
                return $value;
            })          
            ->addColumn('action', function ($getData) {
                $btn = '<a href="'.URL::to('data-guru/ubah/'.Crypt::encrypt($getData->id)).'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-info btn-sm "><i class="far fa-edit"></i></a>';
                $btn .= '&nbsp;';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Hapus" class="delete btn btn-danger btn-sm "><i class="fas fa-trash-alt"></i></a>';
                return  $btn;
            })
            ->rawColumns(['action','bidang_pengembangan','role'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('data-guru.index');
    }

    public function create()
    {
        $data['asal_satuan'] = Ms_DataSekolah::orderBy('kode_wilayah_induk_kecamatan','ASC')->orderBy('created_at','ASC')->get();    
        $data['kab']= Regency::all();
        $data['prov'] = Province::all();
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        return view('data-guru.create', $data);
    }

    public function store(Request $request) 
    {
        $nama = $request->gelardepan.' '.$request->nama_lengkap.' '.$request->gelar_blkg;
        $date = strtotime($request->tgllahir);
        $password = date('d', $date).date("m", $date).date("Y", $date);
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
        $id = Crypt::decrypt($id);
        $data['get'] = Biodata::with('user')->find($id);
        $data['asal_satuan'] = Ms_DataSekolah::orderBy('kode_wilayah_induk_kecamatan','ASC')->orderBy('created_at','ASC')->get();    
        $data['kab']= Regency::all();
        $data['prov'] = Province::all();
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        $data['jenjang'] = Ms_JenjangPendidikanDikti::all();
        // return $data['getData'];
        return view('data-guru.edit', $data);
       
    }

    public function update(Request $request)
    {        
        $id = Crypt::decrypt($request->id);
        $nama = $request->gelardepan.' '.$request->nama_lengkap.' '.$request->gelar_blkg;
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
            'siswa' => $request->siswa,
            'status_sekolah' => $request->status_sekolah,
            'gender' => $request->gender,
            'asal_satuan_pendidikan' => $request->asal_satuan,
            'is_active' => 1,
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
}
