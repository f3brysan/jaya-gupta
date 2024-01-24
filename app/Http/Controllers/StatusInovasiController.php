<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use App\Models\NilaiInovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StatusInovasiController extends Controller
{
    public function index_inovasi()
    {
        $waiting = Inovasi::with('nilai.owner', 'owner','inovasibidangpengembangan.bidangpengembangan')->doesntHave('nilai')->where('status', 1)->where('jenis', 1)->get();
        $done =  Inovasi::with('nilai.owner', 'owner','inovasibidangpengembangan.bidangpengembangan')->has('nilai')->where('status', 1)->where('jenis', 1)->get();
        $all = Inovasi::with('nilai.owner', 'owner','inovasibidangpengembangan.bidangpengembangan')->where('status', 1)->where('jenis', 1)->get();
        // return $waiting;
        return view('kurator.inovasi', compact('waiting', 'done', 'all'));
    }

    public function index_aksi()
    {
        $waiting = Inovasi::with('nilai.owner', 'owner')->doesntHave('nilai')->where('status', 1)->where('jenis', 2)->get();
        $done =  Inovasi::with('nilai.owner', 'owner')->has('nilai')->where('status', 1)->where('jenis', 2)->get();
        $all = Inovasi::with('nilai.owner', 'owner')->where('status', 1)->where('jenis', 2)->get();
        // return $done;
        return view('kurator.aksi', compact('waiting', 'done', 'all'));
    }

    public function nilai(Request $request)
    {        
        $id = Crypt::decrypt($request->id);
        $inovasi = Inovasi::where('id', $id)->first();
        // dd($inovasi);
        if ($request->status == 'terima') {
            $status = 1;
        } else {
            $status = 0;
        }

        $memo = $request->memo ?? '';

        $nilai = NilaiInovasi::create([
         'inovasi_id' => $inovasi->id,
         'bio_id' => auth()->user()->id,
         'status' => $status,
         'memo' => $memo
        ]);

        if ($nilai) {
            if ($inovasi->jenis == 1) {
                return redirect('kurator/inovasi')->with('success', 'Inovasi Praktik Baik berhasil dinilai.');
            } else {
                return redirect('kurator/aksi-nyata')->with('success', 'Aksi Nyata Praktik Baik berhasil dinilai.');
            }                        
        }
    }

}
