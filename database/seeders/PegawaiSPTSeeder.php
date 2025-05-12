<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PegawaiSPT;

class PegawaiSPTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relasi = [
            [ 'spt_id' => 1, 'pegawai_id' => 1 ],
            [ 'spt_id' => 1, 'pegawai_id' => 2 ],
        ];

        foreach ($relasi as $data) {
            PegawaiSPT::create([
                'spt_id' => $data['spt_id'],
                'pegawai_id' => $data['pegawai_id'],
            ]);
        }
    }
}
