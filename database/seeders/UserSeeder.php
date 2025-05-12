<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            //1
            [
                'nama' => 'Sophina Shafa Salsabila',
                'email' => 'admin@mail.com',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
            ],

            //2
            [
                'nama' => 'Toni Harisman, S.Sos., M.Si.',
                'email' => 'ssophinaa@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'pegawai',
            ],

            //3
            [
                'nama' => 'Marzalena, S.T., M.T.',
                'email' => 'yanamonce@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'pegawai',
            ],

            //4
            [
                'nama' => 'Susila, S.H.',
                'email' => 'pegawai@mail.com',
                'password' => bcrypt('12345678'),
                'role' => 'pegawai',
            ],

            //5
            [
                'nama' => 'Novalianti Putri, S.E.',
                'email' => 'pegawai2@mail.com',
                'password' => bcrypt('12345678'),
                'role' => 'pegawai',
            ],

            //6
            [
                'nama' => 'Angga Tamara Mukti, S.T.',
                'email' => 'pegawai3@mail.com',
                'password' => bcrypt('12345678'),
                'role' => 'pegawai',
            ],

            //7
            [
                'nama' => 'Sri Wahyuni',
                'email' => 'pegawai4@mail.com',
                'password' => bcrypt('12345678'),
                'role' => 'pegawai',
            ],

            //8
            [
                'nama' => 'Javier Riando',
                'email' => 'pegawai5@mail.com',
                'password' => bcrypt('12345678'),
                'role' => 'pegawai',
            ],

            //9
            [
                'nama' => 'Siti Yuniana',
                'no_hp' => '0812345678',
                'role' => 'permohonan',
            ],

            //10
            [
                'nama' => 'Yura Yunia',
                'no_hp' => '0812345678',
                'role' => 'permohonan',
            ],

            //11
            [
                'nama' => 'Budi Santoso',
                'no_hp' => '0821123456',
                'role' => 'permohonan',
            ],

            //12
            [
                'nama' => 'Rina Maharani',
                'no_hp' => '0812896543',
                'role' => 'permohonan',
            ],

            //13
            [
                'nama' => 'Ahmad Ridwan',
                'no_hp' => '0852678901',
                'role' => 'permohonan',
            ],

            //14
            [
                'nama' => 'Dewi Kartika',
                'no_hp' => '0877765432',
                'role' => 'permohonan',
            ],

            //15
            [
                'nama' => 'Yusuf Hidayat',
                'no_hp' => '0812345671',
                'role' => 'permohonan',
            ],

            //16
            [
                'nama' => 'Nur Aisyah',
                'no_hp' => '0899987654',
                'role' => 'permohonan',
            ],

            //17
            [
                'nama' => 'Fajar Ramadhan',
                'no_hp' => '0821345678',
                'role' => 'permohonan',
            ],

            //18
            [
                'nama' => 'Melati Sari',
                'no_hp' => '0813456723',
                'role' => 'permohonan',
            ],

            //19
            [
                'nama' => 'Andi Wijaya',
                'no_hp' => '0856789123',
                'role' => 'permohonan',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
