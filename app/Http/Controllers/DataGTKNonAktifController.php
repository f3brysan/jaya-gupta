<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;

class DataGTKNonAktifController extends Controller
{
    public function index()
    {
        $user_guru = User::role('nonaktif')->pluck('id');
        if (auth()->user()->hasRole('superadmin')) {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->get();
        } else {
            $getData = Biodata::with('user', 'user.roles', 'asal_sekolah', 'user_bidang_pengembangan.bidangpengembangan')->whereIn('id', $user_guru)->where('asal_satuan_pendidikan', auth()->user()->bio->asal_satuan_pendidikan)->get();
        }

        return view('data-gtk-nonaktif.index', compact('getData'));
    }
}
