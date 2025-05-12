<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    protected $fillable = [
        'permohonan_id',
        'topografi',
        'gambar_lahan',
        'luas_lahan',
        'jenis_lahan',
        'pemanfaatan',
        'kondisi_sekitar',
        'koor_a',
        'koor_b',
        'koor_c',
        'koor_d',
        'peruntukan',
        'no_ba',
        'no_lhp',
        'file_laporan',
        // 'file_ba',
        // 'file_lhp',
        // 'arsip',
        'updated_by',
        'selesai_at'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
