<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\WasteRequest;
use App\Models\WasteCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WasteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_shows_input_weight_page_with_correct_data()
    {
        // Membuat user dengan role 'user' dan login
        $user = User::create([
            'role' => 'user',
            'name' => 'Imam Wijayanto',
            'email' => 'imamwijayanto@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08078789002',
            'location' => 'Brussels Spring, No. 7, Jalan Veteran,
            Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Login sebagai user
        $this->actingAs($user);

        // Membuat user organisasi daur ulang (recycleorg)
        $recycleOrg = User::create([
            'role' => 'recycleorg',
            'name' => 'Bank Sampah Sukma Mulya',
            'email' => 'bssukmamulya123@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08176789001',
            'location' => 'Gang Cibunut Utara, Kebon Pisang, Sumur Bandung,
            Bandung, West Java, Java, 40112, Indonesia',
        ]);


        // Membuat permintaan sampah dengan recycleorgID yang valid
        $wasteRequest = WasteRequest::create([
            'user_id' => $user->id,
            'recycleorgID' => $recycleOrg->id,
            'status' => 'pending',
            'expiryDate' => now()->addDays(2),
        ]);

        // Menyisipkan kategori sampah langsung ke database
        WasteCategory::insert([
            ['type' => 'Botol Plastik Besar'],
            ['type' => 'Botol Plastik Kecil'],
            ['type' => 'Botol Kaca Besar'],
            ['type' => 'Botol Kaca Kecil'],
            ['type' => 'Kaleng'],
            ['type' => 'Kertas'],
        ]);

        // Mengirimkan permintaan GET ke halaman input berat sampah
        $response = $this->get(route('inputWeight', ['wasteRequestID' => $wasteRequest->id]));

        // Memastikan halaman dimuat dengan status 200 (OK)
        $response->assertStatus(200);

        // Memastikan view yang benar dikembalikan
        $response->assertViewIs('inputWeight');

        // Memastikan wasteRequest diteruskan ke view
        $response->assertViewHas('wasteRequest', $wasteRequest);

        // Memastikan kategori sampah diteruskan ke view
        $response->assertViewHas('categories', function ($categoriesView) {
            // Memeriksa apakah kategori yang dikembalikan di view sesuai dengan yang dibuat
            return $categoriesView->contains('type', 'Botol Plastik Besar') && $categoriesView->contains('type', 'Botol Plastik Kecil')
                && $categoriesView->contains('type', 'Botol Kaca Besar') && $categoriesView->contains('type', 'Botol Kaca Kecil')
                && $categoriesView->contains('type', 'Kaleng') && $categoriesView->contains('type', 'Kertas');
        });

        // Memastikan wasteRequestID diteruskan ke view
        $response->assertViewHas('wasteRequestID', $wasteRequest->id);
    }

    // /** @test */
    // public function it_stores_waste_data_and_redirects_to_home_page_with_six_categories()
    // {
    //     // Buat user dengan role 'user'
    //     $user = User::create([
    //         'role' => 'user',
    //         'name' => 'John Doe',
    //         'email' => 'johndoe@example.com',
    //         'password' => Hash::make('password123'),
    //         'phonenumber' => '0987654321',
    //         'location' => 'Some Address',
    //     ]);

    //     // Buat organisasi recycle dengan role 'recycleorg'
    //     $recycleOrg = User::create([
    //         'role' => 'recycleorg',
    //         'name' => 'Recycle Org',
    //         'email' => 'recycleorg@example.com',
    //         'password' => Hash::make('password123'),
    //         'phonenumber' => '0987654321',
    //         'location' => 'Some Address',
    //     ]);

    //     // Log in sebagai user
    //     $this->actingAs($user);

    //     // Buat permintaan waste
    //     $wasteRequest = WasteRequest::create([
    //         'user_id' => $user->id,
    //         'recycleorgID' => $recycleOrg->id,
    //         'status' => 'pending',
    //         'expiryDate' => now()->addDays(2),
    //     ]);

    //     // Buat kategori waste
    //     $categories = [
    //         WasteCategory::create(['type' => 'Botol Plastik Besar']),
    //         WasteCategory::create(['type' => 'Botol Plastik Kecil']),
    //         WasteCategory::create(['type' => 'Botol Kaca Besar']),
    //         WasteCategory::create(['type' => 'Botol Kaca Kecil']),
    //         WasteCategory::create(['type' => 'Kaleng']),
    //         WasteCategory::create(['type' => 'Kertas']),
    //     ];

    //     // Data kategori dan berat
    //     $categoriesData = [
    //         ['category_id' => $categories[0]->id, 'weight' => 10],
    //         ['category_id' => $categories[1]->id, 'weight' => 15],
    //         ['category_id' => $categories[2]->id, 'weight' => 5],
    //         ['category_id' => $categories[3]->id, 'weight' => 8],
    //         ['category_id' => $categories[4]->id, 'weight' => 12],
    //         ['category_id' => $categories[5]->id, 'weight' => 20],
    //     ];

    //     // Kirim POST request untuk menyimpan data waste
    //     $response = $this->post(route('storeData'), [
    //         'wasteRequestID' => $wasteRequest->id,
    //         'categories' => json_encode($categoriesData),
    //     ]);

    //     // Total berat dan poin
    //     $totalWeight = array_sum(array_column($categoriesData, 'weight'));
    //     $totalPoints = $totalWeight * 100; // Misalnya 100 poin/kg

    //     // Pastikan data tersimpan di tabel waste_data
    //     $this->assertDatabaseHas('waste_data', [
    //         'wasteRequestID' => $wasteRequest->id,
    //         'userID' => $user->id,
    //         'total_weight' => $totalWeight,
    //         'points' => $totalPoints,
    //     ]);

    //     // Ambil wasteDataID untuk validasi category_waste_data
    //     $wasteData = WasteData::where('wasteRequestID', $wasteRequest->id)->first();

    //     // Simpan data kategori dan berat ke tabel category_waste_data
    //     foreach ($categoriesData as $category) {
    //         CategoryWasteData::create([
    //             'wasteDataID' => $wasteData->id, // Harus sesuai wasteDataID
    //             'categoryID' => $category['category_id'],
    //             'weight' => $category['weight'],
    //         ]);
    //     }

    //     // Pastikan data tersimpan di tabel category_waste_data
    //     foreach ($categoriesData as $category) {
    //         $this->assertDatabaseHas('category_waste_data', [
    //             'wasteDataID' => $wasteData->id, // Harus sesuai wasteDataID
    //             'categoryID' => $category['category_id'],
    //             'weight' => $category['weight'],
    //         ]);
    //     }

    //     // Pastikan redirect ke halaman utama user
    //     $response->assertRedirect(route('home.homeUser'));
    //     $response->assertStatus(302); // Status redirect
    // }
}
