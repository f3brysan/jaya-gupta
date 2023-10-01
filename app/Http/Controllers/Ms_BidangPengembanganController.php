<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Ms_BidangPengembangan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class Ms_BidangPengembanganController extends Controller
{
    public function index(Request $request)
    {
        $getData = Ms_BidangPengembangan::get();
        if ($request -> ajax()) {
            return DataTables::of($getData)
            ->addColumn('action', function ($getData) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Edit" class="edit btn btn-info btn-sm "><i class="far fa-edit"></i></a>';
                $btn .= '&nbsp;';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.Crypt::encrypt($getData->id).'" data-name="'.$getData->nama.'" data-original-title="Hapus" class="delete btn btn-danger btn-sm "><i class="fas fa-trash-alt"></i></a>';
                return  $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('master.bidang_pengembangan.index');
    }

    public function store(Request $request)
    {
        try {            
            $is_aktif = !empty($request->is_aktif) ? true : false;            

            $result = Ms_BidangPengembangan::updateOrCreate(
                ['id' => $request->id],
                ['nama' => $request->nama,
                'created_by' => Session::get('user')->name,
                'is_aktif' => $is_aktif]
            );

            return response()->json($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);

            $data = Ms_BidangPengembangan::where('id', $id)->first();

            return response()->json($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $id = Crypt::decrypt($id);

            $data = Ms_BidangPengembangan::where('id', $id)->delete();

            return response()->json($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
