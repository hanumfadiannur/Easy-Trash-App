<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_login_successfully_as_user()
    {
        // Membuat user dengan role 'user'
        $user = User::create([
            'name' => 'Imam Wijayanto',
            'email' => 'imamwijayanto@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'user',
            'phonenumber' => '08078789002',
            'location' => 'Brussels Spring, No. 7, Jalan Veteran, Kebon Pisang,
             Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Menyiapkan data login
        $data = [
            'email' => 'imamwijayanto@gmail.com',
            'password' => '123456',
            'role' => 'user'
        ];

        // Mengirim permintaan POST ke route login
        $response = $this->post(route('account.login'), $data);

        // Memastikan user diarahkan ke halaman home user dengan pesan sukses
        $response->assertRedirect(route('home.homeUser'));
        $response->assertSessionHas('success', "Login successful! Welcome back, Imam Wijayanto.");
    }
}
