<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Biodata;
use App\Models\Regency;
use App\Models\Province;
use App\Models\Ms_Pangkat;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use App\Models\Ms_MataPelajaran;
use Illuminate\Support\Facades\DB;
use App\Models\Ms_SatuanPendidikan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Ms_BidangPengembangan;
use App\Models\Ms_JenjangPendidikanDikti;
use Illuminate\Support\Facades\Crypt;
use App\Models\UserBidangPengembangan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Session as FacadesSession;

class BiodataController extends Controller
{
    public function show()
    {
        $id = auth()->user()->id;
        $data['get'] = Biodata::where('id',$id)->first();        
        $data['roles'] = auth()->user()->getRoleNames();
        $data['prov'] = Province::all();
        $data['kab']= Regency::all();
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        $data['asal_satuan'] = Ms_DataSekolah::orderBy('npsn','ASC')->get();        
        $data['bidang_pengembangan'] = UserBidangPengembangan::where('bio_id', $id)->with('bidangpengembangan')->get();
        $data['jenjang'] = Ms_JenjangPendidikanDikti::all();
        $data['mapel'] = Ms_MataPelajaran::all();
        $user_bp = $data['bidang_pengembangan']->pluck('bidang_pengembangan_id');

        if (count($user_bp)>0) {
            $data['ms_bidang_pengembangan'] = Ms_BidangPengembangan::whereNotIn('id', $user_bp)->get();
        } else {
            $data['ms_bidang_pengembangan'] = Ms_BidangPengembangan::get();
        }
                
        // return $kab;
        return view('biodata.index', $data);    
    }

    public function store(Request $request)
    {    
        $id = Crypt::decrypt($request->id);        
        $nama = $request->gelardepan . ' ' . $request->nama_lengkap . ' ' . $request->gelar_blkg;
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

        $check = Http::withHeaders([
            'client_secret' => 'haloguru_secretkey',
        ])->get('http://103.242.124.108:3033/sync-users/'.$id);     

        if ($check['message'] == 'User not found') {
            $asal_sekolah = Ms_DataSekolah::where('npsn', auth()->user()->bio->asal_satuan_pendidikan)->first();
            $password = '12345678';
            $date = strtotime($request->tgllahir);
                    $password = date('d', $date) . date("m", $date) . date("Y", $date);
            $send = Http::withHeaders([
                'client_secret' => 'haloguru_secretkey',
            ])->post('http://103.242.124.108:3033/sync-users', [
                        'id' => $id,
                        'email' => $request->email,
                        'nama' => $nama,
                        'password' => $password,
                        'roleId' => 'gtk',
                        'foto' => null,
                        'biografi' => null,
                        'firebase_token' => null,
                        'gtk' => [
                            'nip_nuptk' => $request->nuptk,
                            'mata_pelajaran' => null,
                            'media_pembelajaran' => [                                
                            ],
                            'pangkat' => $request->status_kepegawaian,
                            'golongan' => $request->golongan,
                            'jabatan' => null,
                            'unit_kerja' => $asal_sekolah->nama,
                            'riwayat_pendidikan' => $request->jurusan,
                        ]
                    ]);
        } else {
            $send = Http::withHeaders([
                'client_secret' => 'haloguru_secretkey',
            ])->patch('http://103.242.124.108:3033/sync-users/'.$id, [                    
                        'email' => $request->email,
                        'nama' => $nama,                                                           
                        'biografi' => null,                    
                        'gtk' => [
                            'nip_nuptk' => $request->nuptk,
                            'mata_pelajaran' => null,
                            'media_pembelajaran' => [],
                            'pangkat' => $request->status_kepegawaian,
                            'golongan' => $request->golongan,
                            'jabatan' => null,                        
                            'riwayat_pendidikan' => $request->jurusan
                        ]
                    ]);
        }

        if ($send['message'] == 'success') {
            DB::commit();
            return redirect('/biodata')->with('success', 'Perubahan berhasil disimpan.');
        } else {
            DB::rollBack();
            return redirect('/biodata')->with('error', 'Data gagal disimpan. '.$send['message']);
        }
    }

    public function show_password()
    {
        // dd(session::all('errors'));
        $id = auth()->user()->id;
        $user = User::find($id)->first();
        
        return view('password.index', compact('user'));    
    }

    public function store_password(Request $request)
    {        
        $id = auth()->user()->id;
        $user = auth()->user();

        // check password tersimpan dengan inputan
        if (!Hash::check($request->oldpswd, $user->password)) {                        
            return back()->with('wrong', 'Sandi lama Anda salah !');
        }

        if ($request->newpswd !== $request->newpswd2) {            
            return back()->with('wrong', 'Password baru Anda tidak sama.');
        } 

        $user->update([
            'password' => Hash::make($request->newpswd),
        ]);

        $send = Http::withHeaders([
            'client_secret' => 'haloguru_secretkey',
        ])->patch('http://103.242.124.108:3033/sync-users/change-password/'.$id , [
            'oldPassword' => $request->oldpswd,
            'newPassword' => $request->newpswd
        ]);
        
        
        request()->session()->invalidate();

        request()->session()->regenerateToken();
    
        return redirect('/')->with('success', 'Silahkan masuk dengan sandi baru!');
    }

    public function tambah_bidang_pengembangan(Request $request) 
    {
        
        try {
            DB::beginTransaction();
            $bio_id = Crypt::decrypt($request->bio_id);
            $bidang_pengembangan_id = Crypt::decrypt($request->bidang_pengembangan_id);
            $insert = UserBidangPengembangan::create([
                'bio_id' => $bio_id,
                'bidang_pengembangan_id' => $bidang_pengembangan_id,
                'created_by' => auth()->user()->id
            ]);

            if ($insert) {
                
               $temp = array();
                $get_user_bidang_pengembangan = UserBidangPengembangan::where('bio_id', $bio_id)->get();                
                foreach ($get_user_bidang_pengembangan as $bp) {                    
                    array_push($temp, $bp->bidang_pengembangan_id);
                }                                             

                $send = Http::withHeaders([
                    'client_secret' => 'haloguru_secretkey',
                ])->patch('http://103.242.124.108:3033/sync-users/'.$bio_id, [                    
                            "gtk" => [  
                                "media_pembelajaran" => $temp
                        ]
                    ]);
            }           

            if($send['message'] == "success"){
                DB::commit();
                return redirect('/biodata')->with('success', 'Data Bidang Pengembangan berhasil disimpan.');
            }

            
        } catch (\Exception $e) {
            return $e->getMessage();
                DB::rollBack();
                return redirect('/biodata')->with('wrong', $e->getMessage());
        }
    }
    public function hapus_bidang_pengembangan($id){        
        $delete = UserBidangPengembangan::destroy($id);
        $temp = array();
        $bio_id = auth()->user()->bio->id;
                $get_user_bidang_pengembangan = UserBidangPengembangan::where('bio_id', $bio_id)->get();                
                foreach ($get_user_bidang_pengembangan as $bp) {                    
                    array_push($temp, $bp->bidang_pengembangan_id);
                }                            
                                    
                $send = Http::withHeaders([
                    'client_secret' => 'haloguru_secretkey',
                ])->patch('http://103.242.124.108:3033/sync-users/'.$bio_id, [                    
                            "gtk" => [  
                                "media_pembelajaran" => $temp
                        ]
                    ]);
        return response()->json($delete);
    }
}
