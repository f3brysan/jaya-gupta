<?php

namespace App\Http\Controllers;

use App\Models\Ms_SatuanPendidikan;
use Illuminate\Http\Request;

class Ms_SatuanPendidikanController extends Controller
{
    public function index() 
    {
        $data['satpen'] = Ms_SatuanPendidikan::orderBy('npsn','ASC')->get();
        return view('master.satuan_pendidikan.index', $data);
    }
}
