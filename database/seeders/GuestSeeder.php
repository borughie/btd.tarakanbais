<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        $instansiList = [
            'Dinas Pendidikan Kota Tarakan',
            'PT. Maju Bersama',
            'Yayasan Pendidikan Nusantara',
            'Kantor Camat Tarakan Utara',
            'RSUD Tarakan',
            'PT. Sinar Mas',
            'Bank BRI Cabang Tarakan',
            'Dinas Kesehatan Kota Tarakan',
            'Polres Tarakan',
            'Kodim 0907/Tarakan',
        ];

        $tujuanList = [
            'Kunjungan kerja',
            'Rapat koordinasi',
            'Penyerahan donasi',
            'Monitoring kegiatan belajar mengajar',
            'Kerjasama pendidikan',
            'Konsultasi administrasi',
            'Pengambilan dokumen',
            'Sosialisasi program',
            'Evaluasi kinerja',
            'Pertemuan dengan kepala sekolah',
        ];

        foreach (range(1, 20) as $i) {
            Guest::create([
                'instansi' => fake()->randomElement($instansiList),
                'tujuan' => fake()->randomElement($tujuanList),
                'jumlah_personil' => fake()->numberBetween(1, 10),
                'nama_pic' => fake()->name(),
                'no_hp' => fake()->phoneNumber(),
                'notified' => fake()->boolean(80),
                'created_at' => fake()->dateTimeBetween('-7 days', 'now'),
            ]);
        }
    }
}
