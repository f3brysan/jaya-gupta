<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'ms_mata_pelajaran';

    protected $guarded = [
        'id'
    ];
}
