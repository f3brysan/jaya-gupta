<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;
    protected $table = 'ms_biodatauser';

    protected $guarded = [
        
    ];   

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }
    
    public function asal_sekolah()
    {
        return $this->belongsTo(Ms_SatuanPendidikan::class, 'asal_satuan_pendidikan', 'npsn');
    }

    public function user_bidang_pengembangan()
    {
        return $this->hasMany(UserBidangPengembangan::class, 'bio_id', 'id');
    }
}
