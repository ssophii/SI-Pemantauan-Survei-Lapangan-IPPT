<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SPT;

class SPTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spts = [
          [
            'permohonan_id' => 1,
            //'pegawai_id' => 2,
            'no_surat' => '800.1.11.1/22/D.PR&KP.P/IV/2025',
            'pelaksanaan' => '2025-05-14',
            'penetapan' => '2025-05-11',
            'status' => 'peninjauan',
            
          ],  
        ];

        foreach ($spts as $spt) {
            SPT::create($spt);
        }
    }
}
