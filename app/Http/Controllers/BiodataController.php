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
use Illuminate\Support\Facades\Crypt;
use App\Models\UserBidangPengembangan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Session as FacadesSession;

class BiodataController extends Controller
{
    public function show()
    {
        $id = auth()->user()->id;
        $data['biodata'] = Biodata::where('id',$id)->first();        
        $data['roles'] = auth()->user()->getRoleNames();
        $data['prov'] = Province::all();
        $data['kab']= Regency::all();
        // $data['matpel'] = Ms_MataPelajaran::orderBy('nama', 'ASC')->get();
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        $data['asal_satuan'] = Ms_DataSekolah::orderBy('npsn','ASC')->get();        
        $data['bidang_pengembangan'] = UserBidangPengembangan::where('bio_id', $id)->with('bidangpengembangan')->get();
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
        if ($request->file('image')) {
            $path =$request->file('image')->store('/images/profile', ['disk' =>   'my_files']);
        }else{
            $check = Biodata::where('id', $request->id)->first();
            if ($check) {
                $path = $check->profile_picture;
            } else {
                $path = NULL;
            }                    
        }

        $nama = $request->gelardepan . ' ' . $request->nama_lengkap . ' ' . $request->gelar_blkg;        
        $update = Biodata::where('id', $request->id)->update([
            'nama' => $nama,
            'nama_lengkap' => $request->nama_lengkap,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_blkg,
            'nip' => $request->nip,                       
            'gender' => $request->gender,            
            'tanggallahir' => $request->tanggallahir,            
            'wa' => $request->wa,
            'profile_picture' => $path
        ]);

        return redirect('/biodata')->with('success', 'Perubahan berhasil disimpan.');
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
        // dd($request->all());
        // $request->validate([
        //     'old_password' => 'required',
        //     'new_password' => 'required|min:8|confirmed',
        // ]);
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
                
               
                $get_user_bidang_pengembangan = UserBidangPengembangan::where('bio_id', $bio_id)->get();                
                foreach ($get_user_bidang_pengembangan as $bp) {
                    $arnpsn[$bp->bidang_pengembangan_id] = '"'.$bp->bidang_pengembangan_id.'"';                    
                    $list =implode(",", $arnpsn);
                }            
                $rec['media_pembelajaran'] = $list;
                // return $rec;
                $user = User::with('bio')->first();                
                $send = Http::withHeaders([
                    'client_secret' => 'haloguru_secretkey',
                ])->patch('http://103.242.124.108:3033/sync-users/'.$bio_id, [                    
                            "gtk" => [                                
                                $rec
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
        return response()->json($delete);
    }
}
