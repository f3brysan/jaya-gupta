<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_MataPelajaran extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ms_mapel';

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'uuid';
}
