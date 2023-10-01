<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Biodata;
use App\Models\Regency;
use App\Models\Province;
use App\Models\Ms_Pangkat;
use Illuminate\Http\Request;
use App\Models\Ms_MataPelajaran;
use Illuminate\Support\Facades\DB;
use App\Models\Ms_SatuanPendidikan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $data['matpel'] = Ms_MataPelajaran::orderBy('nama', 'ASC')->get();
        $data['pangkat'] = Ms_Pangkat::where('is_aktif', true)->orderBy('gol', 'DESC')->get();
        $data['asal_satuan'] = Ms_SatuanPendidikan::orderBy('npsn','ASC')->get();        
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
        // dd($request->all());
        $update = Biodata::where('id', $request->id)->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'asal_satuan_pendidikan' => $request->asal_satuan,
            'golongan' => $request->gol,
            'gender' => $request->gender,
            'tempatlahir' => $request->tempatlahir,
            'tanggallahir' => $request->tanggallahir,
            'provdom' => $request->provdom,
            'kabdom' => $request->kabdom,
            'kecdom' => $request->kecdom, 
            'alamatdom' => $request->alamatdom,
            'wa' => $request->wa
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
// dd($insert);
            if ($insert) {
                DB::commit();
                return redirect('/biodata')->with('success', 'Data Bidang Pengembangan berhasil disimpan.');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
                DB::rollBack();
                return redirect('/biodata')->with('wrong', $e->getMessage());
        }
    }
}
