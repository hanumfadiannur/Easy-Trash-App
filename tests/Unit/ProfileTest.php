<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\MapsUser;
use App\Models\MapsRecycleOrg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji tampilan profil user dengan role 'user'.
     *
     * @return void
     */
    public function test_user_profile()
    {
        // Membuat user dengan role 'user'
        $user = User::create([
            'role' => 'user',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phonenumber' => '1234567890',  // Menambahkan nomor telepon untuk lulus validasi
            'location' => '123 Street Name',
        ]);

        // Membuat data peta yang terkait dengan user
        MapsUser::create([
            'user_id' => $user->id,
            'address' => '123 Street Name',
            'latitude' => 12.345,
            'longitude' => 67.890
        ]);

        // Bertindak sebagai user yang sedang login
        $this->actingAs($user);

        // Meminta halaman profil
        $response = $this->get(route('account.profile'));

        // Memastikan response mengembalikan view yang benar
        $response->assertStatus(200);
        $response->assertViewIs('account.profile');

        // Memastikan data user dan data peta diteruskan ke view
        $response->assertViewHas('user', $user);
        $response->assertViewHas('mapData', $user->mapsUser);
    }

    /**
     * Uji tampilan profil user dengan role 'recycleorg'.
     *
     * @return void
     */
    public function test_recycleorg_profile()
    {
        // Membuat user dengan role 'recycleorg'
        $user = User::create([
            'role' => 'recycleorg',
            'name' => 'Recycle Org',
            'email' => 'RecycleOrg@example.com',
            'password' => Hash::make('password123'),
            'phonenumber' => '0987654321',  // Menambahkan nomor telepon untuk lulus validasi
            'location' => '456 Recycle Street',
        ]);

        // Membuat data peta yang terkait dengan recycleorg
        MapsRecycleOrg::create([
            'user_id' => $user->id,
            'address' => '456 Recycle Street',
            'latitude' => 54.321,
            'longitude' => 98.765
        ]);

        // Bertindak sebagai user yang sedang login
        $this->actingAs($user);

        // Meminta halaman profil
        $response = $this->get(route('account.profile'));

        // Memastikan response mengembalikan view yang benar
        $response->assertStatus(200);
        $response->assertViewIs('account.profile');

        // Memastikan data user dan data peta diteruskan ke view
        $response->assertViewHas('user', $user);
        $response->assertViewHas('mapData', $user->mapsRecycleOrg);
    }

    /**
     * Uji akses profil untuk user yang belum login.
     *
     * @return void
     */
    public function test_profile_for_unauthenticated_user()
    {
        // Mencoba mengakses halaman profil tanpa login terlebih dahulu
        $response = $this->get(route('account.profile'));

        // Memastikan user diarahkan ke halaman login
        $response->assertRedirect(route('account.login'));
    }
}
