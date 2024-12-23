<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\WasteRequest; // Use proper case for model names
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class CreateWasteRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_waste_request_and_redirects_to_input_weight_page()
    {
        // Membuat pengguna dengan peran 'user'
        $user = User::create([
            'role' => 'user',
            'name' => 'Imam Wijayanto',
            'email' => 'imamwijayanto@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08078789002',
            'location' => 'Brussels Spring, No. 7, Jalan Veteran,
            Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Membuat organisasi daur ulang (untuk memilih organisasi daur ulang)
        $recycleOrg = User::create([
            'role' => 'recycleorg',
            'name' => 'Bank Sampah Sukma Mulya',
            'email' => 'bssukmamulya123@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08176789001',
            'location' => 'Gang Cibunut Utara, Kebon Pisang, Sumur Bandung,
            Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Melakukan login sebagai pengguna
        $this->actingAs($user);

        // Mengirimkan request POST untuk membuat permintaan sampah
        $response = $this->post(route('createwasterequest'), [
            'recycleorg_id' => $recycleOrg->id,
        ]);


        $wasteRequest = wasteRequest::latest()->first();


        // Memverifikasi bahwa permintaan sampah dibuat dan diarahkan ke halaman input berat dengan parameter query yang benar
        $response->assertRedirect(route('inputWeight', ['wasteRequestID' => $wasteRequest->id]));

        // Memverifikasi bahwa permintaan sampah telah disimpan dalam database
        $this->assertDatabaseHas('waste_request', [
            'user_id' => $user->id,
            'recycleorgID' => $recycleOrg->id,
            'status' => 'pending',
        ]);
    }
}
