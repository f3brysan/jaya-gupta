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

    public function bidangpengembangan()
    {
        return $this->belongsTo(Ms_BidangPengembangan::class, 'bidang_pengembangan_id', 'id');
    }

    public function inovasi()
    {
        return $this->belonsTo(Inovasi::class, 'inovasi_id', 'id');
    }
}
