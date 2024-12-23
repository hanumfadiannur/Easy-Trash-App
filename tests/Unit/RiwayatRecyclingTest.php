<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WasteRequest;
use App\Models\WasteCategory;
use App\Models\CategoryWasteData;
use App\Models\WasteData;
use Illuminate\Support\Facades\Hash;

class RiwayatRecyclingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_riwayat_recycling_for_logged_in_recycleorg()
    {
        // Membuat user dengan role 'user' dan 'recycleorg'
        $user1 = User::create([
            'role' => 'user',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phonenumber' => '0987654321',
            'location' => '123 Street Name',
        ]);

        $recycleOrg = User::create([
            'role' => 'recycleorg',
            'name' => 'Recycle Org',
            'email' => 'recycleorg@example.com',
            'password' => Hash::make('password123'),
            'phonenumber' => '0987654321',
            'location' => '456 Street Name',
        ]);

        // Melakukan login sebagai recycleorg
        Auth::login($recycleOrg);

        // Membuat kategori sampah
        $category1 = WasteCategory::create(['type' => 'Plastic']);
        $category2 = WasteCategory::create(['type' => 'Paper']);
        $category3 = WasteCategory::create(['type' => 'Metal']);

        // Membuat waste request untuk user1 dengan status 'done' yang terkait dengan recycleorg
        $wasteRequest = WasteRequest::create([
            'user_id' => $user1->id,
            'recycleorgID' => $recycleOrg->id,
            'status' => 'done',
            'expiryDate' => now()->addDays(2),
        ]);

        // Membuat data waste untuk wasteRequest tersebut
        $wasteData = WasteData::create([
            'wasteRequestID' => $wasteRequest->id,
            'userID' => $user1->id,
            'total_weight' => 30, // Berat total akan dihitung
            'points' => 300,      // Poin dihitung berdasarkan berat
        ]);

        // Menambahkan kategori dan berat ke category_waste_data untuk wasteData
        CategoryWasteData::create([
            'wasteDataID' => $wasteData->id,
            'categoryID' => $category1->id,
            'weight' => 10,
        ]);
        CategoryWasteData::create([
            'wasteDataID' => $wasteData->id,
            'categoryID' => $category2->id,
            'weight' => 15,
        ]);
        CategoryWasteData::create([
            'wasteDataID' => $wasteData->id,
            'categoryID' => $category3->id,
            'weight' => 5,
        ]);

        // Memanggil method riwayatRecycling
        $response = $this->get(route('account.riwayatRecycling'));

        // Memastikan request berhasil dan halaman yang tepat ditampilkan
        $response->assertStatus(200);
        $response->assertViewHas('requests');

        // Mengambil data dari tampilan
        $requests = $response->viewData('requests');

        // Memverifikasi bahwa data yang dikembalikan hanya berisi permintaan yang relevan untuk recycleorg yang login
        $this->assertCount(1, $requests); // Pastikan hanya ada satu request yang dikembalikan

        // Memverifikasi total_weight untuk request pertama (seharusnya jumlah berat kategori)
        $totalWeight = $requests[0]->total_weight;
        $this->assertEquals(30, $totalWeight); // Total weight harus 10 + 15 + 5 = 30

        // Memverifikasi bahwa relasi kategori dimuat dengan benar
        $this->assertCount(3, $requests[0]->categories); // Harus ada 3 kategori pada request pertama
    }
}
