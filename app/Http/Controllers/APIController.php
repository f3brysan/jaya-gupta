<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function encode(Request $request)
    {
        try {
            $value = array();
            if ($request->params != NULL) {
                $value['status'] = bcrypt($request->params);
            } else {
                $value['status'] = 'Params tidak boleh NULL';
            }

            return response()->json($value);
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }
}
