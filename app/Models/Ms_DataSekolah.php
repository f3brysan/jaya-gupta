<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_DataSekolah extends Model
{
    use HasFactory;

    protected $table = 'ms_sekolah';
    protected $guarded = [        
    ];

    public function guru()
    {
        return $this->hasMany(Biodata::class, 'asal_satuan_pendidikan','npsn');
    }
}
