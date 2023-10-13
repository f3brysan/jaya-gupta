<?php

namespace App\Http\Controllers;

use App\Models\Ms_BidangPengembangan;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function encode(Request $request)
    {
        try {
            $value = array();
            if ($request->input !== NULL) {
                $value['output'] = bcrypt($request->params);
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
}
