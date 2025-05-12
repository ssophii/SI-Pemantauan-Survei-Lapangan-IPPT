<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'jabatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spts()
    {
        return $this->belongsToMany(SPT::class, 'pegawai_spt', 'pegawai_id', 'spt_id');
    }

}
