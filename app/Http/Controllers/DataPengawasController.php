<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Ms_DataSekolah;
use App\Models\PengawasSekolah;
use Illuminate\Support\Facades\DB;

class DataPengawasController extends Controller
{
    public function index_admin()
    {
        $getPengawas = Biodata::where('is_pengawas', 1)->get();
        return view('data-pengawas.index', compact('getPengawas'));
    }

    public function create()
    {
        $sekolah = Ms_DataSekolah::get();
        $kecamatan = District::where('regency_id', '5171')->get();
        return view('data-pengawas.create', compact('sekolah', 'kecamatan'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'image' => 'image|max:5120'
        ]);
        // dd($request->all());
        DB::beginTransaction();

        if ($request->file('image')) {
            $path_image = $request->file('image')->store('/images/profile', ['disk' => 'my_files']);
        } else {
            $check = Biodata::where('id', $request->id)->first();
            if ($check) {
                $path_image = $check->image;
            } else {
                $path_image = null;
            }
        }

        $insert = Biodata::updateOrCreate(
            ['id' => $request->id],
            [
                'nama_lengkap' => $request->nama_lengkap,
                'nip' => $request->nip,
                'golongan' => $request->golongan,
                'tempatlahir' => $request->tempatlahir,
                'tanggallahir' => $request->tgllahir,
                'usia_pensiun' => $request->usia_pensiun,
                'sertifikasi' => $request->sertifikasi,
                'kecdom' => $request->kecdom,
                'jenjang' => $request->periode_penugasan,
                'profile_picture' => $path_image,
                'is_pengawas' => 1
            ]
        );


        if ($insert) {
            $delete = PengawasSekolah::where('biodata_id', $insert->id)->delete();
            foreach ($request->asal_satuan as $item) {
                $insert_sekolah_pengawas = PengawasSekolah::create([
                    'biodata_id' => $insert->id,
                    'npsn' => $item
                ]);
            }
        }

        if ($insert_sekolah_pengawas) {
            DB::commit();
            return redirect('admin/data-pengawas')->with('success', 'Data berhasil disimpan.');
        } else {
            DB::rollBack();
            return redirect('admin/data-pengawas')->with('error', 'Data gagal disimpan.');
        }





    }
}
