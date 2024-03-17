<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;
    protected $table = 'ms_biodatauser';

    protected $guarded = [
        
    ];   
    public $incrementing = false;
    protected $keyType = 'uuid';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }
    
    public function asal_sekolah()
    {
        return $this->belongsTo(Ms_DataSekolah::class, 'asal_satuan_pendidikan', 'npsn');
    }

    public function user_bidang_pengembangan()
    {
        return $this->hasMany(UserBidangPengembangan::class, 'bio_id', 'id');
    }

    public function pendidikan_dikti()
    {
        return $this->belongsTo(Ms_JenjangPendidikanDikti::class, 'pendidikan_terakhir', 'kode');
    }
    
}
