<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inovasi;
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
        return view('dashboard.index', compact('data'));
    }

    public function get_praktik_baik(Request $request)
    {
        // $getData = Inovasi::with('nilai')->get();
        $getData =  Inovasi::with('nilai.owner', 'owner')->has('nilai')->where('status', 1)->get();
        if ($request -> ajax()) {
            return DataTables::of($getData)
            ->addColumn('deskripsi_readmore', function($getData){
                return Str::words($getData->deskripsi, 25, '...');
            })
            ->editColumn('images', function($getData){
                return '<img src="'.URL::to('').'/'.$getData->image.'" class="img-fluid img-thumbnail" style="height: 100px"/>';
            })
            ->addColumn('action', function ($getData) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Edit" class="edit btn btn-info btn-sm "><i class="far fa-edit"></i></a>';
                $btn .= '&nbsp;';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Hapus" class="delete btn btn-danger btn-sm "><i class="fas fa-trash-alt"></i></a>';
                return  $btn;
            })
            ->rawColumns(['action','deskripsi_readmore','images'])
            ->addIndexColumn()
            ->make(true);
        }
    }
}
