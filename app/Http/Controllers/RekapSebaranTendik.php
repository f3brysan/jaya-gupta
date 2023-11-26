<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapSebaranTendik extends Controller
{
    public function index()
    {
        return view('rekap.sebaran-tendik.index');
    }
}
