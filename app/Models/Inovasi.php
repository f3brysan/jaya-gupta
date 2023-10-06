<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inovasi extends Model
{
    use HasFactory, Uuid;
    protected $table = 'tr_inovasi';

    protected $guarded = [
        'id'
    ];
    
    public $incrementing = false;

    protected $keyType = 'uuid';

    public function owner()
    {
        return $this->belongsTo(Biodata::class,'bio_id', 'id');
    }

    public function nilai()
    {
        return $this->belongsTo(NilaiInovasi::class, 'id', 'inovasi_id');
    }
    public function inovasibidangpengembangan()
    {
        return $this->hasMany(InovasiBidangPengembangan::class, 'inovasi_id', 'id');
    }

}
