<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class DataGuruController extends Controller
{
    public function index(Request $request)
    {
        $getData = Biodata::with('user','user.roles','asal_sekolah','user_bidang_pengembangan.bidangpengembangan')->get();
        // return $getData->where('id','1');
        if ($request -> ajax()) {
            return DataTables::of($getData)
            ->addColumn('asal_sekolah', function($getData){
                $asal_sekolah = $getData->asal_sekolah->nama_satuan ?? '';
                return $asal_sekolah;
            })
            ->addColumn('role', function($getData){
                return $getData->user->roles;
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
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Edit" class="edit btn btn-info btn-sm "><i class="far fa-edit"></i></a>';
                $btn .= '&nbsp;';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Hapus" class="delete btn btn-danger btn-sm "><i class="fas fa-trash-alt"></i></a>';
                return  $btn;
            })
            ->rawColumns(['action','bidang_pengembangan'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('data-guru.index');
    }
}
