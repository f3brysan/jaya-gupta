<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ms_Rombel extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ms_rombel';

    protected $guarded = [
        'id'
    ];
    
    public $incrementing = false;

    protected $keyType = 'uuid';

    public function walikelas()
     {
        return $this->hasOne(Biodata::class, 'nuptk', 'wali_kelas');
    }
}
