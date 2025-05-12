<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permohonan extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        // 'nama',
        // 'no_hp',
        'id_pendaftaran',
        'atas_nama',
        'alamat_jalan',
        'alamat_kelurahan',
        'alamat_kecamatan',
        'lokasi_jalan',
        'lokasi_kelurahan',
        'lokasi_kecamatan',
        'luas_lahan',
        'penggunaan',
        'kepemilikan',
        'status',
        'no_surat',
        'file_surat',
        'tanggal_masuk',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function spt()
    {
        return $this->hasOne(SPT::class);
    }

    public function survei()
    {
        return $this->hasOne(Survei::class);
    }
}
