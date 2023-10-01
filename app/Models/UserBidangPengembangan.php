<?php

namespace App\Models;


use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserBidangPengembangan extends Model
{    
use HasFactory, Uuid;
    protected $table = 'user_bidang_pengembangan';

    protected $guarded = [
        'id'
    ];
    
    public $incrementing = false;

    protected $keyType = 'uuid';

    public function bidangpengembangan()
    {
        return $this->belongsTo(Ms_BidangPengembangan::class, 'bidang_pengembangan_id', 'id');
    }
}
