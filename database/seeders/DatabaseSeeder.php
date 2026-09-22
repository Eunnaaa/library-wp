<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'nama' => 'Administrator E-Library',
            'email' => 'admin@gmail.com',
            'alamat' => 'Jl. Kramat Raya No. 98, Senen, Jakarta Pusat',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'is_active' => 1,
            'image' => 'profil-pic/default.jpg',
        ]);

        // 2. Akun Member/Anggota
        $member = User::create([
            'nama' => 'Gary Hardyansyah',
            'email' => 'gary@gmail.com',
            'alamat' => 'Jl. Dago Asri No. 12, Bandung',
            'password' => Hash::make('12345678'),
            'role_id' => 2,
            'is_active' => 1,
            'image' => 'profil-pic/default.jpg',
        ]);

        // 3. Kategori Buku
        $kategoriList = [
            'Komputer & Teknologi',
            'Sains & Matematika',
            'Ekonomi & Bisnis',
            'Sastra & Fiksi',
            'Pengembangan Diri',
        ];

        $kategoriModels = [];
        foreach ($kategoriList as $k) {
            $kategoriModels[$k] = Kategori::create([
                'nama_kategori' => $k,
            ]);
        }

        // 4. Koleksi Buku
        $bukuList = [
            [
                'judul_buku' => 'Pemrograman Web dengan Framework Laravel 11',
                'id_kategori' => $kategoriModels['Komputer & Teknologi']->id,
                'pengarang' => 'Gary Hardyansyah',
                'penerbit' => 'Informatika Press',
                'tahun_terbit' => '2024',
                'isbn' => '978-602-8758-01-2',
                'stok' => 10,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/laravel.jpg',
            ],
            [
                'judul_buku' => 'Belajar Mudah Python untuk Pemula',
                'id_kategori' => $kategoriModels['Komputer & Teknologi']->id,
                'pengarang' => 'Budi Raharjo',
                'penerbit' => 'Modula',
                'tahun_terbit' => '2023',
                'isbn' => '978-602-8758-02-9',
                'stok' => 8,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/python.jpg',
            ],
            [
                'judul_buku' => 'Dasar-Dasar Rekayasa Perangkat Lunak',
                'id_kategori' => $kategoriModels['Komputer & Teknologi']->id,
                'pengarang' => 'Rosa A. S. & M. Shalahuddin',
                'penerbit' => 'Informatika',
                'tahun_terbit' => '2022',
                'isbn' => '978-602-8758-03-6',
                'stok' => 5,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/rpl.jpg',
            ],
            [
                'judul_buku' => 'Machine Learning dan AI Praktis',
                'id_kategori' => $kategoriModels['Sains & Matematika']->id,
                'pengarang' => 'Suyanto, Ph.D.',
                'penerbit' => 'Andi Publisher',
                'tahun_terbit' => '2023',
                'isbn' => '978-979-29-6842-1',
                'stok' => 6,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/ml.jpg',
            ],
            [
                'judul_buku' => 'Basis Data Relasional dan SQL Modern',
                'id_kategori' => $kategoriModels['Komputer & Teknologi']->id,
                'pengarang' => 'Abdul Kadir',
                'penerbit' => 'Andi Offset',
                'tahun_terbit' => '2021',
                'isbn' => '978-979-29-5431-8',
                'stok' => 7,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/sql.jpg',
            ],
            [
                'judul_buku' => 'Manajemen Bisnis dan Kewirausahaan Digital',
                'id_kategori' => $kategoriModels['Ekonomi & Bisnis']->id,
                'pengarang' => 'Prof. Rhenald Kasali',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun_terbit' => '2022',
                'isbn' => '978-602-06-4321-4',
                'stok' => 4,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/bisnis.jpg',
            ],
            [
                'judul_buku' => 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa',
                'id_kategori' => $kategoriModels['Pengembangan Diri']->id,
                'pengarang' => 'James Clear',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun_terbit' => '2020',
                'isbn' => '978-602-06-3317-8',
                'stok' => 12,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/habits.jpg',
            ],
            [
                'judul_buku' => 'Laskar Pelangi',
                'id_kategori' => $kategoriModels['Sastra & Fiksi']->id,
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2019',
                'isbn' => '978-979-1227-84-5',
                'stok' => 8,
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => 'cover-buku/laskar.jpg',
            ],
        ];

        foreach ($bukuList as $bukuData) {
            Buku::create($bukuData);
        }
    }
}
