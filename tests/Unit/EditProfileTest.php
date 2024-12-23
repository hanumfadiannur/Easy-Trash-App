<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\MapsRecycleOrg;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test profile update for 'recycleorg' role.
     *
     * @return void
     */
    public function test_update_recycleorg_profile()
    {
        // Membuat pengguna dengan role 'recycleorg'
        $user = User::create([
            'role' => 'recycleorg',
            'name' => 'Bank Sampah Sukma Mulya',
            'email' => 'bssukmamulya@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08176789001',
            'location' => 'Jalan Natuna, Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Mensimulasikan pengguna yang sudah login
        $this->actingAs($user);

        // Data yang akan diupdate pada profil
        $data = [
            'name' => 'Bank Sampah Sukma Mulya',
            'email' => 'bssukmamulya123@gmail.com',
            'phonenumber' => '08176789001',
            'location' => 'Gang Cibunut Utara, Kebon Pisang, Sumur Bandung, Bandung,
            West Java, Java, 40112, Indonesia',
            'latitude' => 21.1234,
            'longitude' => 65.4321,
        ];

        // Mengirim permintaan POST untuk memperbarui profil
        $response = $this->post(route('account.updateProfile'), $data);

        // Memastikan data profil berhasil diperbarui
        $user->refresh();
        $this->assertEquals('bssukmamulya123@gmail.com', $user->email);
        $this->assertEquals('Gang Cibunut Utara, Kebon Pisang, Sumur Bandung, Bandung,
            West Java, Java, 40112, Indonesia', $user->location);

        // Memastikan data peta untuk organisasi daur ulang berhasil diperbarui
        $mapsRecycleOrg = MapsRecycleOrg::where('user_id', $user->id)->first();
        $this->assertEquals('Gang Cibunut Utara, Kebon Pisang, Sumur Bandung, Bandung,
            West Java, Java, 40112, Indonesia', $mapsRecycleOrg->address);
        $this->assertEquals(21.1234, $mapsRecycleOrg->latitude);
        $this->assertEquals(65.4321, $mapsRecycleOrg->longitude);

        // Memastikan pengguna diarahkan kembali dengan pesan sukses
        $response->assertRedirect(route('account.profile'));
        $response->assertSessionHas('success', 'Profile updated successfully');
    }
}
