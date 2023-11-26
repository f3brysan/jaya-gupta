<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapGuruPenggerak extends Controller
{
    public function index()
    {
        return view('rekap.guru-penggerak.index');
    }
}
