<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_Pangkat extends Model
{
    use HasFactory;
    protected $table = 'ms_pangkat';

    protected $guarded = [
        'id'
    ];
}
