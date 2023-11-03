<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\User;
use App\Models\Inovasi;
use App\Models\Ms_BidangPengembangan;
use App\Models\Ms_DataSekolah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('guru')) {
            $data['all'] = Inovasi::where('bio_id', auth()->user()->id)->count();
            $data['tolak'] = Inovasi::with('nilai.owner', 'owner')
                ->whereHas('nilai', function ($q) {
                    $q->where('status', 0);
                })
                ->where('bio_id', auth()->user()->id)->count();
            $data['terima'] = Inovasi::with('nilai.owner', 'owner')
                ->whereHas('nilai', function ($q) {
                    $q->where('status', 1);
                })
                ->where('bio_id', auth()->user()->id)->count();
            $data['waiting'] = Inovasi::with('nilai.owner', 'owner')->doesntHave('nilai')->where('status', 1)->where('bio_id', auth()->user()->id)->count();
        } else {
            $data['all'] = Inovasi::count();
            $data['tolak'] = Inovasi::with('nilai.owner', 'owner')
                ->whereHas('nilai', function ($q) {
                    $q->where('status', 0);
                })
                ->count();
            $data['terima'] = Inovasi::with('nilai.owner', 'owner')
                ->whereHas('nilai', function ($q) {
                    $q->where('status', 1);
                })
                ->count();
            $data['waiting'] = Inovasi::with('nilai.owner', 'owner')->doesntHave('nilai')->count();
        }
        // return $inovasi;

        $getData = Inovasi::with('nilai.owner', 'owner', 'inovasibidangpengembangan.bidangpengembangan')->has('nilai')->where('status', 1)->whereHas('nilai', function($q){
            $q->where('status', 1);
        })->get();
        $bid_pengembangan = Ms_BidangPengembangan::get();
        $dataSekolah = Ms_DataSekolah::where('npsn', auth()->user()->bio->asal_satuan_pendidikan)->first();
        $npsn = $dataSekolah->npsn;
        $kepalasekolah = User::with('bio')->role('kepalasekolah')->whereHas('bio', function ($q) use( $npsn ) {
            $q->where('asal_satuan_pendidikan', $npsn);
        })->first();
        $jmlguru = Biodata::where('asal_satuan_pendidikan', $npsn)->count();
        // dd($npsn);
        return view('dashboard.index', compact('data', 'getData', 'bid_pengembangan', 'dataSekolah', 'kepalasekolah', 'jmlguru'));
    }

    public function get_praktik_baik(Request $request)
    {
        // $getData = Inovasi::with('nilai')->get();
        // $getData = Inovasi::with('nilai.owner', 'owner', 'inovasibidangpengembangan.bidangpengembangan')->has('nilai')->where('status', 1)->get();
        $getData = Inovasi::with('nilai.owner', 'owner', 'inovasibidangpengembangan.bidangpengembangan')->has('nilai')->where('status', 1)->whereHas('nilai', function($q){
            $q->where('status', 1);
        })->get();
        if ($request->ajax()) {
            return DataTables::of($getData)
                ->addColumn('deskripsi_readmore', function ($getData) {
                    return Str::words($getData->deskripsi, 15, '...');
                })
                ->editColumn('images', function ($getData) {
                    return '<img src="' . URL::to('') . '/' . $getData->image . '" class="img-fluid img-thumbnail" style="height: 100px"/>';
                })
                ->addColumn('action', function ($getData) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-info m-1" title="Lihat Data"
                    data-toggle="modal" data-target="#modal'.$getData->id.'"><i
                        class="far fa-eye"></i></a>';
                    return $btn;
                })
                ->editColumn('updated_at', function ($getData) {
                    return date_format(date_create($getData->updated_at),'Y-m-d H:i');
                })
                ->addColumn('bidang_pengembangan', function ($getData) {
                    $value = '';
                    foreach ($getData->inovasibidangpengembangan as $inovasi) {
                        $value .= '<li>' . $inovasi->bidangpengembangan->nama . '</li>';
                    }

                    return $value;
                })
                ->rawColumns(['action', 'deskripsi_readmore', 'images', 'bidang_pengembangan'])
                ->addIndexColumn()
                ->make(true);
        }
        
    }
}
