<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Regency;
use Illuminate\Http\Request;

class IndoController extends Controller
{
    public function getkabupaten($id)
    {
        $kabupaten = Regency::where("province_id", $id)->pluck('id','name');
        return response()->json($kabupaten);
    }

    public function getkecamatan($id)
    {
        try {
            $kecamatan = District::where("regency_id", $id)->pluck('id','name');
        } catch (\Exception $e) {
            return $e->getMessage();
        }       
        return response()->json($kecamatan);
    }
}
