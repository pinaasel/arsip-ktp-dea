<?php

namespace Database\Seeders;

use App\Models\Ktp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KtpSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $petugas = User::where('role', 'petugas')->get();

        for ($i = 0; $i < 50; $i++) {
            $tanggalLahir = Carbon::createFromTimestamp(
                $faker->dateTimeBetween('-60 years', '-17 years')->getTimestamp()
            );

            Ktp::create([
                'nik' => $faker->unique()->numerify('################'),
                'nama_lengkap' => $faker->name,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $tanggalLahir,
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O', '-']),
                'alamat' => $faker->streetAddress,
                'rt_rw' => sprintf('%03d/%03d', $faker->numberBetween(1, 999), $faker->numberBetween(1, 999)),
                'kel_desa' => $faker->city,
                'kecamatan' => $faker->city,
                'kota' => $faker->city,
                'provinsi' => $faker->state,
                'kode_pos' => $faker->postcode,
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya']),
                'status_perkawinan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']),
                'pekerjaan' => $faker->jobTitle,
                'kewarganegaraan' => 'WNI',
                'foto_ktp' => 'default.jpg',
                'status' => 'aktif',
                'berlaku_hingga' => Carbon::now()->addYears(10),
                'petugas_id' => $faker->randomElement($petugas)->id,
            ]);
        }
    }
}
