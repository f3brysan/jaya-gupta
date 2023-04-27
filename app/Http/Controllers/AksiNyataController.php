<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use App\Models\TempInovasi;
use Illuminate\Support\Str;
use App\Models\NilaiInovasi;
use Illuminate\Http\Request;
use App\Models\TempNilaiInovasi;
use Illuminate\Support\Facades\Crypt;

class AksiNyataController extends Controller
{
    public function index()
    {
        $aksi = Inovasi::with('nilai.owner')->where('bio_id', auth()->user()->id)->where('jenis', 2)->get();
        // return $inovasi;
        return view('aksi.index', compact('aksi'));
    }

    public function tambah()
    {
        return view('aksi.tambah');

    }

    public function store(Request $request)
    {
        $nilai = Inovasi::with('nilai.owner')->where('id', $request->id)->first();
        // dd($nilai->nilai->id);
        if ($nilai->nilai) {
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
        
        if ($request->submit == 'pub') {
            $status = 1;
        } else {
            $status = 0;
        }


        if ($request->file('image')) {
            $path =$request->file('image')->store('/images/aksi', ['disk' =>   'my_files']);
        }else{
            $check = Inovasi::where('id', $request->id)->first();
            if ($check) {
                $path = $check->image;
            } else {
                $path = NULL;
            }                    
        }

        $insert = Inovasi::updateOrCreate([
            'id' => $request->id
        ],
        [
            'judul' => ucwords($request->judul),
            'slug' => Str::slug($request->judul),
            'bio_id' => auth()->user()->id,
            'deskripsi' => $request->deskripsi,
            'video' => $request->video,
            'image' => $path,
            'status' => $status,
            'jenis' => 2
        ]);

        if ($insert) {
            return redirect('guru/aksi-nyata')->with('success', 'Data berhasil disimpan.');
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $inovasi = Inovasi::where('id', $id)->first();
        return view('aksi.edit',compact('inovasi'));
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
            'status' =>$inovasi->status,
            'jenis' => $inovasi->jenis
        ]);
        
        // $move = "INSERT INTO temp_tr_inovasi SELECT * FROM tr_inovasi WHERE tr_inovasi.id = '$id'";
        // $exe = DB::getpdo()->exec($move);

        if ($move) {
            $inovasi = Inovasi::where('id', $id)->delete();
            return redirect('guru/aksi-nyata')->with('success', 'Data berhasil disimpan.');
        }
    }
}
