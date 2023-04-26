<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiInovasi extends Model
{
    use HasFactory, Uuid;
    protected $table = 'tr_inovasi_nilai';

    protected $guarded = [
        'id'
    ];
    
    public $incrementing = false;

    protected $keyType = 'uuid';

    public function owner()
    {
        return $this->belongsTo(Biodata::class, 'bio_id', 'id');
    }

}
