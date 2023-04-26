<?php

namespace App\Http\Controllers;

use App\Models\Inovasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('guru')) {
            $data['all'] = Inovasi::where('bio_id', auth()->user()->id)->count();
            $data['tolak'] = Inovasi::with('nilai.owner', 'owner')
                                        ->whereHas('nilai', function ($q) {
                                            $q->where('status', 0);
                                        })
                                        ->where('bio_id', auth()->user()->id)->count();
            $data['terima'] = Inovasi::with('nilai.owner', 'owner')
            ->whereHas('nilai', function ($q) {
                $q->where('status', 1);
            })
            ->where('bio_id', auth()->user()->id)->count();
            $data['waiting'] = Inovasi::with('nilai.owner', 'owner')->doesntHave('nilai')->where('status', 1)->where('bio_id', auth()->user()->id)->count();
        } else {
            $data['all'] = Inovasi::count();
            $data['tolak'] = Inovasi::with('nilai.owner', 'owner')
                                        ->whereHas('nilai', function ($q) {
                                            $q->where('status', 0);
                                        })
                                        ->count();
            $data['terima'] = Inovasi::with('nilai.owner', 'owner')
            ->whereHas('nilai', function ($q) {
                $q->where('status', 1);
            })
           ->count();
            $data['waiting'] = Inovasi::with('nilai.owner', 'owner')->doesntHave('nilai')->count();
        }
        // return $inovasi;
        return view('dashboard.index', compact('data'));
    }
}
