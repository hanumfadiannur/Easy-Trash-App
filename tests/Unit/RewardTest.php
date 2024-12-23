<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class RewardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the reward and point functionality for a user.
     *
     * @return void
     */
    public function test_reward_and_point_functionality()
    {
        // Buat user yang akan digunakan untuk pengujian
        $user = User::create([
            'role' => 'user',
            'name' => 'Imam Wijayanto',
            'email' => 'imamwijayanto@gmail.com',
            'password' => Hash::make('123456'),
            'phonenumber' => '08078789002',
            'location' => 'Brussels Spring, No. 7, Jalan Veteran,
            Kebon Pisang, Sumur Bandung, Bandung, West Java, Java, 40112, Indonesia',
            'points' => 7000,
        ]);

        // Simulasikan user sebagai yang sedang login
        $this->actingAs($user);

        // Buat beberapa reward
        $reward1 = Reward::create([
            'name' => 'Vas Bunga Plastik',
            'description' => 'Vas bunga plastik ini terbuat dari bahan tahan lama dengan desain elegan,
             memberikan tampilan bunga segar yang sama seperti bunga asli. Cocok sebagai dekorasi rumah atau hadiah.',
            'points_required' => 100,
            'stock' => 50,
            'category' => 'Hiasan',
        ]);

        // Kirim request ke route yang mengarah ke method rewardAndPoint
        $response = $this->get(route('pointReward.pointReward'));

        // Cek apakah response berisi data yang benar
        $response->assertViewIs('pointReward.pointReward');
        $response->assertViewHas('user', $user);
        $response->assertViewHas('rewards');
        $response->assertViewHas('redeemedRewards');

        // Verifikasi bahwa jika tidak ada RewardTransaction, redeemedCount harus 0
        $redeemedCount = $user->rewardTransactions()->count();
        $response->assertViewHas('redeemedCount', $redeemedCount);

        // Pastikan jumlah reward yang ada sesuai dengan yang diharapkan
        $response->assertViewHas('rewards', function ($rewards) use ($reward1) {
            return $rewards->contains($reward1);
        });
    }
}
