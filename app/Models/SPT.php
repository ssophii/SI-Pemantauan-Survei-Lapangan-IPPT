<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SPT extends Model
{
    protected $table = 'spts';
    protected $fillable = [
        'permohonan_id',
        'no_surat',
        'pelaksanaan',
        'penetapan',
        'status',
        'file_spt',
    ];
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function pegawais()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_spt', 'spt_id', 'pegawai_id');
    }
}
