<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Pelajaran;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // User Seeder
        $dataKelas = [
            [
                'nama_kelas' => 'Tidak ada',
                'kode_kelas' => '-',
                'angkatan' => '-',
                'deskripsi' => '-',
            ],
            [
                'nama_kelas' => '12 RPL 2',
                'kode_kelas' => '12rpl22024qwe12',
                'angkatan' => '2024',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adip',
            ],
            [
                'nama_kelas' => '11 RPL 2',
                'kode_kelas' => '11rpl22023qw512',
                'angkatan' => '2023',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adip',
            ],
        ];

        foreach ($dataKelas as $key => $val) {
            Kelas::create($val);
        }
        // User Seeder
        $dataUser = [
            [
                'fullname' => 'admin',
                'username' => 'admin123',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('admin'),
                'id_kelas' => 1,

            ],
            [
                'fullname' => 'guru',
                'username' => 'guru123',
                'email' => 'guru@gmail.com',
                'role' => 'guru',
                'password' => bcrypt('guru'),
                'id_kelas' => 1,
            ],
            [
                'fullname' => 'siswa',
                'username' => 'siswa123',
                'email' => 'siswa@gmail.com',
                'role' => 'siswa',
                'password' => bcrypt('siswa'),
                'id_kelas' => 1,

            ],
            [
                'fullname' => 'Adel Zenin',
                'username' => 'aderu',
                'email' => 'adel@gmail.com',
                'role' => 'siswa',
                'password' => bcrypt('password'),
                'id_kelas' => 1,

            ],
        ];

        foreach ($dataUser as $key => $val) {
            User::create($val);
        }


        // Pelajaran Seeder
        $dataPelajaran = [
            [
                'mata_pelajaran' => 'Matematika',
                'id_kelas' => 3,
                'id_guru' => 2,
                'deskripsi' => 'lorem ipsum dolor sit amet, consect',
                'foto' => 'default.jpg',
            ],
            [
                'mata_pelajaran' => 'Matematika',
                'id_kelas' => 2,
                'id_guru' => 2,
                'deskripsi' => 'lorem ipsum dolor sit amet, consect',
                'foto' => 'default.jpg',
            ],
            [
                'mata_pelajaran' => 'Bahasa Inggris',
                'id_kelas' => 2,
                'id_guru' => 2,
                'deskripsi' => 'lorem ipsum dolor sit amet, consect',
                'foto' => 'default.jpg',
            ],
        ];

        foreach ($dataPelajaran as $key => $val) {
            Pelajaran::create($val);
        }
    }
}
