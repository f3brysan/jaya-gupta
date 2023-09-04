<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_BidangPengembangan extends Model
{
    use HasFactory;
    protected $table = 'ms_bidang_pengembangan';

    protected $guarded = [
        'id'
    ];
}
