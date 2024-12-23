<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WasteRequest;
use App\Models\WasteData;
use Illuminate\Support\Facades\Hash;

class WasteDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_report()
    {
        // Membuat user
        $user = User::create([
            'role' => 'user',
            'name' => 'Imam Wijayanto',
            'email' => 'imamwijayanto@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08078789002',
            'location' => 'Brussels Spring, No. 7, Jalan Veteran,
            Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Membuat organisasi daur ulang
        $recycleOrg = User::create([
            'role' => 'recycleorg',
            'name' => 'Bank Sampah Sukma Mulya',
            'email' => 'bssukmamulya123@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08176789001',
            'location' => 'Gang Cibunut Utara, Kebon Pisang, Sumur Bandung,
            Bandung, West Java, Java, 40112, Indonesia',
        ]);

        // Membuat permintaan sampah yang terhubung dengan user dan organisasi daur ulang
        $wasteRequest = WasteRequest::create([
            'user_id' => $user->id,
            'recycleorgID' => $recycleOrg->id,
            'status' => 'done',
            'expiryDate' => now()->addDays(2),
        ]);

        // Membuat data sampah yang terkait dengan permintaan sampah
        WasteData::create([
            'wasteRequestID' => $wasteRequest->id,
            'userID' => $user->id,
            'total_weight' => 10,
            'points' => 1000,
        ]);

        // Melakukan login sebagai user
        Auth::login($user);

        // Memanggil metode notificationReport
        $response = $this->get('/account/notification-report');

        // Memastikan status respons adalah 200
        $response->assertStatus(200);

        // Memastikan data diteruskan ke view
        $response->assertViewHas('recyclingPoints');
        $response->assertViewHas('recyclingRequests');
    }
}
