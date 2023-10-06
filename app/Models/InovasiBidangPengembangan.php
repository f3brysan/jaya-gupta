<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InovasiBidangPengembangan extends Model
{
    use HasFactory, Uuid;
    protected $table = 'tr_inovasi_bidang_pengembangan';

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'uuid';
}
