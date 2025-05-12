<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiSPT extends Model
{
    protected $table = 'pegawai_spt';

    protected $fillable = [
        'pegawai_id',
        'spt_id'
    ];
}
