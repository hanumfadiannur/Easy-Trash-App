<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddRewardsAndWasteCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert rewards data
        DB::table('rewards')->insert([
            [
                'name' => 'Vas Bunga Plastik',
                'description' => 'Vas bunga plastik ini terbuat dari bahan tahan lama dengan desain elegan, memberikan tampilan bunga segar yang sama seperti bunga asli. Cocok sebagai dekorasi rumah atau hadiah.',
                'points_required' => 100,
                'stock' => 50,
                'category' => 'Hiasan',
                'image' => 'vas-bunga.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pot Tanaman Kecil',
                'description' => 'Pot tanaman kecil yang minimalis, ideal untuk mempercantik meja kerja, ruang tamu, atau kamar tidur dengan sentuhan hijau yang menenangkan.',
                'points_required' => 120,
                'stock' => 30,
                'category' => 'Hiasan',
                'image' => 'pot-tanaman.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kap Lampu Gantung',
                'description' => 'Kap lampu gantung modern yang memberikan nuansa hangat dan estetis untuk ruang makan atau ruang tamu Anda.',
                'points_required' => 300,
                'stock' => 10,
                'category' => 'Hiasan',
                'image' => 'kap-lampu.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Lampu Hias',
                'description' => 'Lampu hias portabel yang cocok untuk dekorasi kamar tidur atau sebagai hadiah spesial.',
                'points_required' => 150,
                'stock' => 25,
                'category' => 'Hiasan',
                'image' => 'lampu-hias.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Alat Makan',
                'description' => 'Set alat makan berkualitas tinggi yang terdiri dari piring, sendok, garpu, dan gelas. Cocok untuk makan bersama keluarga.',
                'points_required' => 200,
                'stock' => 40,
                'category' => 'Peralatan',
                'image' => 'alat-makan.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tempat Pensil',
                'description' => 'Tempat alat tulis adalah wadah untuk menyimpan alat tulis seperti pensil, pulpen, penghapus, dan penggaris, agar tetap rapi dan mudah diakses.',
                'points_required' => 80,
                'stock' => 70,
                'category' => 'Peralatan',
                'image' => 'tempat-pensil.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kotak Pensil',
                'description' => 'Kotak pensil yang praktis dan tahan lama, cocok untuk anak sekolah atau pekerja kantoran.',
                'points_required' => 90,
                'stock' => 60,
                'category' => 'Peralatan',
                'image' => 'kotak-pensil.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tempat Bumbu',
                'description' => 'Tempat bumbu dapur ini memudahkan Anda menyimpan rempah-rempah dengan rapi dan menjaga kualitasnya.',
                'points_required' => 110,
                'stock' => 35,
                'category' => 'Peralatan',
                'image' => 'tempat-bumbu.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Insert waste category data
        DB::table('waste_category')->insert([
            ['type' => 'Botol Plastik Besar', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Botol Plastik Kecil', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Botol Kaca Besar', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Botol Kaca Kecil', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Kaleng', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'Kertas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete the inserted data
        DB::table('rewards')->whereIn('name', [
            'Vas Bunga Plastik',
            'Pot Tanaman Kecil',
            'Kap Lampu Gantung',
            'Lampu Hias',
            'Alat Makan',
            'Tempat Pensil',
            'Kotak Pensil',
            'Tempat Bumbu'
        ])->delete();

        DB::table('waste_category')->whereIn('type', [
            'Botol Plastik Besar',
            'Botol Plastik Kecil',
            'Botol Kaca Besar',
            'Botol Kaca Kecil',
            'Kaleng',
            'Kertas'
        ])->delete();
    }
}
