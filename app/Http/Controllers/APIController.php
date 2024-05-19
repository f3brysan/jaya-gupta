<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Models\Ms_BidangPengembangan;

class APIController extends Controller
{
    public function encode(Request $request)
    {
        try {
            $value = array();
            
            if ($request->input !== NULL) {
                $value['output'] = Hash::make($request->input);
            } else {
                $value['output'] = 'Params tidak boleh NULL';
            }

            return response()->json($value);
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function getBidangKompetensi()
    {        
        $getData = Ms_BidangPengembangan::all();

        return response()->json(['output' => $getData]);
    }

    public function hashcheck(Request $request){
        $password = $request->password;
        $hashedPassword = $request->hash_password;

        try {
            if (Hash::check($password, $hashedPassword)) {
                $result = true;
            }else{
                $result = false;
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return $e->getMessage();    
        }
    }

    public function get_praktik_baik()
    {
        try {
            $getData = Inovasi::with('nilai.owner', 'owner', 'inovasibidangpengembangan.bidangpengembangan')->has('nilai')->where('status', 1)->whereHas('nilai', function ($q) {
                $q->where('status', 1);
            })->get();
    
            $data = array();
            foreach ($getData as $item) {
                $data[$item->id]['id'] = $item->id;
                $data[$item->id]['judul'] = $item->judul;
                $data[$item->id]['deskripsi'] = $item->deskripsi;
                $data[$item->id]['video'] = $item->video;
                $data[$item->id]['owner'] = $item->owner->nama ?? '';
                // $data[$item->id]['bidang_pengembangan'] = $item->inovasibidangpengembangan;
                $i = 0;
                foreach ($item->inovasibidangpengembangan as $bp) {
                    $data[$item->id]['bidang_pengembangan'][$i++] = $bp->bidangpengembangan->nama;
                }
    
                $data[$item->id]['dikurasi_pada'] = $item->nilai->created_at;
                $data[$item->id]['dikurasi_oleh'] = $item->nilai->owner->nama ?? '';
                $data[$item->id]['link_sumber'] = $item->link;
                $data[$item->id]['dokumen_pendukung'] = $item->document == NULL ? NULL : URL::to('/').'/'.$item->document;
                $data[$item->id]['slug'] = URL::to('/').'/api/praktik-baik/detail/'.$item->slug;
                $data[$item->id]['image'] = $item->image == NULL ? NULL : URL::to('/').'/'.$item->image;
                $data[$item->id]['jenis'] = $item->jenis == 1 ? 'Inovasi Praktik Baik' : 'Aksi Nyata Praktik Baik';
            }
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function detail_praktik_baik($slug)
    {
        $getData = Inovasi::with('nilai.owner', 'owner', 'inovasibidangpengembangan.bidangpengembangan')->has('nilai')->where('status', 1)->whereHas('nilai', function ($q) {
            $q->where('status', 1);
        })->where('slug', $slug)->first();
        
        $data = array();

        $data['id'] = $getData->id;
        $data['judul'] = $getData->judul;
        $data['deskripsi'] = $getData->deskripsi;
        $data['video'] = $getData->video;
        $data['owner'] = $getData->owner->nama;
        
        $data['dikurasi_pada'] = $getData->nilai->created_at;
        $data['dikurasi_oleh'] = $getData->nilai->owner->nama;
        $data['link_sumber'] = $getData->link;
        $i = 0;
        foreach ($getData->inovasibidangpengembangan as $bp) {
            $data['bidang_pengembangan'][$i++] = $bp->bidangpengembangan->nama;
        }
        $data['dokumen_pendukung'] = $getData->document == NULL ? NULL : URL::to('/').'/'.$getData->document;        
        $data['image'] = $getData->image == NULL ? NULL : URL::to('/').'/'.$getData->image;
        $data['jenis'] = $getData->jenis == 1 ? 'Inovasi Praktik Baik' : 'Aksi Nyata Praktik Baik';

        return response()->json($data);
    }
}
