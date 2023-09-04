<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_SatuanPendidikan extends Model
{
    use HasFactory;
    protected $table = 'ms_satuan_pendidikan';

    protected $guarded = [
        'id'
    ];
}
