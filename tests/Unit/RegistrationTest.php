<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\MapsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji keberhasilan pendaftaran untuk organisasi daur ulang.
     *
     * @return void
     */
    public function test_recycleorg_registration_success()
    {
        // Data permintaan palsu untuk pendaftaran organisasi daur ulang
        $data = [
            'name' => 'Bank Sampah Sukma Mulya',
            'email' => 'bssukmamulya@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'phonenumber' => '08176789001',
            'role' => 'recycleorg',
            'location' => 'Jalan Natuna, Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
            'latitude' => 1.234567,
            'longitude' => 2.345678
        ];

        // Memanggil route pendaftaran
        $response = $this->post(route('account.register'), $data);

        // Memastikan user dibuat dalam database dengan role recycleorg
        $this->assertDatabaseHas('users', [
            'email' => 'bssukmamulya@gmail.com',
            'role' => 'recycleorg'
        ]);

        // Ambil user yang baru dibuat
        $user = User::where('email', 'bssukmamulya@gmail.com')->first();

        // Membuat data peta yang terkait dengan user
        MapsUser::create([
            'user_id' => $user->id,   // Menyimpan ID user yang terkait
            'address' => 'Jalan Natuna, Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
            'latitude' => 1.234567,
            'longitude' => 2.345678
        ]);

        // Memastikan data peta terkait dengan user ada di database
        $this->assertDatabaseHas('maps_user', [
            'user_id' => $user->id,
            'address' => 'Jalan Natuna, Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
            'latitude' => 1.234567,
            'longitude' => 2.345678
        ]);

        // Memastikan redirect ke halaman login dengan pesan sukses
        $response->assertRedirect(route('account.login'))
            ->assertSessionHas('success', 'You have registered successfully.');
    }
}
