<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use App\Models\InovasiBidangPengembangan;
use App\Models\Ms_BidangPengembangan;
use App\Models\NilaiInovasi;
use App\Models\TempInovasi;
use App\Models\TempNilaiInovasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class InovasiController extends Controller
{
    public function index()
    {
        $inovasi = Inovasi::with('nilai.owner')->where('bio_id', auth()->user()->id)->where('jenis', 1)->get();
        // return $inovasi;
        return view('inovasi.index', compact('inovasi'));
    }

    public function tambah()
    {
        $ms_bidang_pengembangan = Ms_BidangPengembangan::all();

        return view('inovasi.tambah', compact('ms_bidang_pengembangan'));

    }

    public function store(Request $request)
    {
       
        try {
            
            DB::beginTransaction();
            $nilai = Inovasi::with('nilai.owner')->where('id', $request->id)->first();
            // dd($nilai->nilai->id);
            if ($nilai) {
                if ($nilai->nilai != null) {
                    $move = TempNilaiInovasi::create([
                        'id' => $nilai->nilai->id,
                        'inovasi_id' => $nilai->nilai->inovasi_id,
                        'bio_id' => $nilai->nilai->bio_id,
                        'status' => $nilai->nilai->status,
                        'point' => $nilai->nilai->point
                    ]);

                    if ($move) {
                        $delNilai = NilaiInovasi::where('id', $nilai->nilai->id)->delete();
                    }
                }
            }


            if ($request->submit == 'pub') {
                $status = 1;
            } else {
                $status = 0;
            }


            if ($request->file('image')) {
                $path = $request->file('image')->store('/images/inovasi', ['disk' =>   'my_files']);
            } else {
                $check = Inovasi::where('id', $request->id)->first();
                if ($check) {
                    $path = $check->image;
                } else {
                    $path = null;
                }
            }

            $insert = Inovasi::updateOrCreate(
                [
                'id' => $request->id],
                [
                'judul' => ucwords($request->judul),
                'slug' => Str::slug($request->judul),
                'bio_id' => auth()->user()->id,
                'deskripsi' => $request->deskripsi,
                'video' => $request->video,
                'image' => $path,
                'status' => $status,
                'jenis' => 1
    ]
            );            

            if ($insert) {
                $delete = InovasiBidangPengembangan::where('inovasi_id', $insert->id);
                foreach ($request->bidang_pengembangan as $item) {
                    $insertIBP = InovasiBidangPengembangan::create([
                        'inovasi_id' => $insert->id,
                        'bidang_pengembangan_id' => $item
                    ]);
                }                               
            }

            if ($insertIBP) {
                DB::commit();                
                return redirect('guru/inovasi')->with('success', 'Data berhasil disimpan.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $inovasi = Inovasi::where('id', $id)->first();
        $ms_bidang_pengembangan = Ms_BidangPengembangan::all();
        $bidang_pengembangan = InovasiBidangPengembangan::where('inovasi_id', $id)->get();
        return view('inovasi.edit', compact('inovasi','bidang_pengembangan','ms_bidang_pengembangan'));
        // return $inovasi;
    }

    public function hapus(Request $request)
    {
        // dd($request->all());
        $id = Crypt::decrypt($request->id);
        // dd($id);
        $inovasi = Inovasi::where('id', $id)->first();

        $move = TempInovasi::create([
            'id' => $inovasi->id,
            'judul' => $inovasi->judul,
            'slug' => $inovasi->slug,
            'bio_id' => $inovasi->bio_id,
            'deskripsi' => $inovasi->deskripsi,
            'video' => $inovasi->video,
            'image' => $inovasi->image,
            'status' => $inovasi->status,
            'jenis' => $inovasi->jenis
        ]);

        // $move = "INSERT INTO temp_tr_inovasi SELECT * FROM tr_inovasi WHERE tr_inovasi.id = '$id'";
        // $exe = DB::getpdo()->exec($move);

        if ($move) {
            $inovasi = Inovasi::where('id', $id)->delete();
            return redirect('guru/inovasi')->with('success', 'Data berhasil dihapus.');
        }
    }
}
