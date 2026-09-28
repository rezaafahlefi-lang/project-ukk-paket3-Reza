<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;
use App\Models\Kategori;

class DataAwalSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan Array sesuai permintaan soal (Gunakan Array)
        $admins = [
            ['username' => 'admin_sarana', 'password' => Hash::make('admin123')],
        ];
        
        $siswas = [
            ['nis' => '213.45', 'kelas' => 'XII RPL 1', 'password' => Hash::make('siswa123')],
            ['nis' => '213.46', 'kelas' => 'XII RPL 2', 'password' => Hash::make('siswa123')],
        ];

        $kategoris = [
            ['ket_kategori' => 'Fasilitas Kelas (Meja/Kursi)'],
            ['ket_kategori' => 'Fasilitas Laboratorium'],
            ['ket_kategori' => 'Fasilitas Umum (Toilet/Kantin)'],
        ];

        // Insert menggunakan prosedur looping sederhana
        foreach ($admins as $admin) {
            Admin::create($admin);
        }

        foreach ($siswas as $siswa) {
            Siswa::create($siswa);
        }

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}