<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Survei;

class SurveiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surveis = [
            [
                'permohonan_id' => 1,
                'topografi' => 'topografi',
                'jenis_lahan' => 'jenis_lahan',
                'pemanfaatan' => 'pemanfaatan',
                'kondisi_sekitar' => 'kondisi_sekitar',
                'koor_a' => 'koor_a',
                'koor_b' => 'koor_b',
                'koor_c' => 'koor_c',
                'koor_d' => 'koor_d',
                'peruntukan' => 'peruntukan',
            ],
        ];

        foreach ($surveis as $survei) {
            Survei::create($survei);
        }
    }
}
