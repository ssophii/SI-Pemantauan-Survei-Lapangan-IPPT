<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $pegawais = [
          [
            'user_id' => 2,
            'nip' => '197003101997031004',
            'jabatan' => 'kadis',
          ],  

          [
            'user_id' => 3,
            'nip' => '197805262006042019',
            'jabatan' => 'kabid',
          ],

          [
            'user_id' => 4,
            'nip' => '197501052010012005',
            'jabatan' => 'penata',
          ],

          [
            'user_id' => 5,
            'nip' => '198311242009032007',
            'jabatan' => 'penata',
          ],

          [
            'user_id' => 6,
            'nip' => '198704162014021001',
            'jabatan' => 'analis',
          ],

          [
            'user_id' => 7,
            'nip' => '197010032007012005',
            'jabatan' => 'pengelola',
          ],

          [
            'user_id' => 8,
            'jabatan' => 'ptt',
          ],
        ];

        foreach ($pegawais as $pegawai) {
            Pegawai::create($pegawai);
        }
    }
}
