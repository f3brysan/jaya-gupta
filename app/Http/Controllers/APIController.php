<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Ms_BidangPengembangan;

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
}
