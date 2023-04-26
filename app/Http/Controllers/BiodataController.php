<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function show()
    {
        $id = auth()->user()->id;
        $biodata = Biodata::find($id)->first();
        $roles = auth()->user()->getRoleNames();
        $prov = Province::all();
        $kab = Regency::all();
        // return $kab;
        return view('biodata.index', compact('biodata', 'roles','prov', 'kab'));    
    }

    public function store(Request $request)
    {
        $update = Biodata::where('id', $request->id)->update([
            'nama' => $request->nama,
            'gender' => $request->gender,
            'tempatlahir' => $request->tempatlahir,
            'tanggallahir' => $request->tanggallahir,
            'provdom' => $request->provdom,
            'kabdom' => $request->kabdom,
            'kecdom' => $request->kecdom, 
            'alamatdom' => $request->alamatdom,
            'wa' => $request->wa
        ]);

        return redirect('/biodata');
    }
}
