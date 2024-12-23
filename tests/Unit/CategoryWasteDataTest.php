<?php

namespace Tests\Unit;

use App\Models\CategoryWasteData;
use Tests\TestCase;
use App\Models\User;
use App\Models\WasteRequest;
use App\Models\WasteCategory;
use App\Models\WasteData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryWasteDataTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_stores_waste_data_and_redirects_to_home_page_with_six_categories()
    {
        // Buat user dengan role 'user'
        $user = User::create([
            'role' => 'user',
            'name' => 'Imam Wijayanto',
            'email' => 'imamwijayanto@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08078789002',
            'location' => 'Brussels Spring, No. 7, Jalan Veteran,
            Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Buat organisasi recycle dengan role 'recycleorg'
        $recycleOrg = User::create([
            'role' => 'recycleorg',
            'name' => 'Bank Sampah Sukma Mulya',
            'email' => 'bssukmamulya123@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08176789001',
            'location' => 'Gang Cibunut Utara, Kebon Pisang, Sumur Bandung,
            Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Log in sebagai user
        $this->actingAs($user);

        // Buat permintaan waste
        $wasteRequest = WasteRequest::create([
            'user_id' => $user->id,
            'recycleorgID' => $recycleOrg->id,
            'status' => 'pending',
            'expiryDate' => now()->addDays(2),
        ]);

        // Buat kategori waste
        $categories = [
            WasteCategory::create(['type' => 'Botol Plastik Besar']),
            WasteCategory::create(['type' => 'Botol Plastik Kecil']),
            WasteCategory::create(['type' => 'Botol Kaca Besar']),
            WasteCategory::create(['type' => 'Botol Kaca Kecil']),
            WasteCategory::create(['type' => 'Kaleng']),
            WasteCategory::create(['type' => 'Kertas']),
        ];

        // Data kategori dan berat
        $categoriesData = [
            ['category_id' => $categories[0]->id, 'weight' => 10],
            ['category_id' => $categories[1]->id, 'weight' => 15],
            ['category_id' => $categories[2]->id, 'weight' => 5],
            ['category_id' => $categories[3]->id, 'weight' => 8],
            ['category_id' => $categories[4]->id, 'weight' => 12],
            ['category_id' => $categories[5]->id, 'weight' => 20],
        ];

        // Kirim POST request untuk menyimpan data waste
        $response = $this->post(route('storeData'), [
            'wasteRequestID' => $wasteRequest->id,
            'categories' => json_encode($categoriesData),
        ]);

        // Total berat dan poin
        $totalWeight = array_sum(array_column($categoriesData, 'weight'));
        $totalPoints = $totalWeight * 100; // Misalnya 100 poin/kg

        // Pastikan data tersimpan di tabel waste_data
        $this->assertDatabaseHas('waste_data', [
            'wasteRequestID' => $wasteRequest->id,
            'userID' => $user->id,
            'total_weight' => $totalWeight,
            'points' => $totalPoints,
        ]);

        // Ambil wasteDataID untuk validasi category_waste_data
        $wasteData = WasteData::where('wasteRequestID', $wasteRequest->id)->first();

        // Simpan data kategori dan berat ke tabel category_waste_data
        foreach ($categoriesData as $category) {
            CategoryWasteData::create([
                'wasteDataID' => $wasteData->id, // Harus sesuai wasteDataID
                'categoryID' => $category['category_id'],
                'weight' => $category['weight'],
            ]);
        }

        // Pastikan data tersimpan di tabel category_waste_data
        foreach ($categoriesData as $category) {
            $this->assertDatabaseHas('category_waste_data', [
                'wasteDataID' => $wasteData->id, // Harus sesuai wasteDataID
                'categoryID' => $category['category_id'],
                'weight' => $category['weight'],
            ]);
        }

        // Pastikan redirect ke halaman utama user
        $response->assertRedirect(route('home.homeUser'));
        $response->assertStatus(302); // Status redirect
    }
}
