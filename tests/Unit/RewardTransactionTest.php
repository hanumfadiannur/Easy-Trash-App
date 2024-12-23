<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Reward;
use App\Models\RewardTransaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RewardTransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test berhasil menukarkan reward.
     *
     * @return void
     */
    public function test_redeem_reward_successfully()
    {
        // Membuat pengguna dengan poin
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

        // Mensimulasikan pengguna yang sudah login
        $this->actingAs($user);

        // Membuat reward
        $reward = Reward::create([
            'name' => 'Vas Bunga Plastik',
            'description' => 'Vas bunga plastik ini terbuat dari bahan tahan lama dengan desain elegan.',
            'points_required' => 100, // Reward memerlukan 100 poin
            'stock' => 50,
            'category' => 'Hiasan',
        ]);

        // Mengirimkan permintaan untuk menukarkan reward
        $response = $this->post(route('reward.redeem'), [
            'reward_id' => $reward->id,
        ]);

        // Memastikan poin telah dikurangi dan stok berkurang
        $user->refresh();
        $reward->refresh();
        $this->assertEquals(6900, $user->points); // Poin seharusnya berkurang 100
        $this->assertEquals(49, $reward->stock); // Stok seharusnya berkurang 1

        // Memastikan transaksi reward telah dibuat
        $transaction = RewardTransaction::where('user_id', $user->id)
            ->where('reward_id', $reward->id)
            ->first();
        $this->assertNotNull($transaction);

        // Memastikan pengguna diarahkan ke halaman detail transaksi dengan pesan sukses
        $response->assertRedirect(route('pointReward.transactionDetail', ['transaction' => $transaction->id]));
        $response->assertSessionHas('success', 'Points Successfully Exchanged.');
    }

    /**
     * Test menukarkan reward saat pengguna tidak memiliki cukup poin.
     *
     * @return void
     */
    public function test_redeem_reward_insufficient_points()
    {
        // Membuat pengguna dengan poin tidak cukup
        $user = User::create([
            'role' => 'user',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phonenumber' => '0987654321',
            'location' => 'Some Address',
            'points' => 50, // Pengguna hanya memiliki 50 poin
        ]);

        // Mensimulasikan pengguna yang sudah login
        $this->actingAs($user);

        // Membuat reward
        $reward = Reward::create([
            'name' => 'Vas Bunga Plastik',
            'description' => 'Vas bunga plastik ini terbuat dari bahan tahan lama.',
            'points_required' => 100, // Reward memerlukan 100 poin
            'stock' => 50,
            'category' => 'Hiasan',
        ]);

        // Mengirimkan permintaan untuk menukarkan reward
        $response = $this->post(route('reward.redeem'), [
            'reward_id' => $reward->id,
        ]);

        // Memastikan pesan error muncul karena poin tidak cukup
        $response->assertRedirect();
        $response->assertSessionHas('error', 'You dont have enough points to redeem this reward.');
    }

    /**
     * Test menukarkan reward saat stok reward tidak tersedia.
     *
     * @return void
     */
    public function test_redeem_reward_no_stock()
    {
        // Membuat pengguna dengan poin yang cukup
        $user = User::create([
            'role' => 'user',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phonenumber' => '0987654321',
            'location' => 'Some Address',
            'points' => 200, // Pengguna memiliki poin yang cukup
        ]);

        // Mensimulasikan pengguna yang sudah login
        $this->actingAs($user);

        // Membuat reward dengan stok 0
        $reward = Reward::create([
            'name' => 'Vas Bunga Plastik',
            'description' => 'Vas bunga plastik ini terbuat dari bahan tahan lama.',
            'points_required' => 100, // Reward memerlukan 100 poin
            'stock' => 0, // Tidak ada stok yang tersedia
            'category' => 'Hiasan',
        ]);

        // Mengirimkan permintaan untuk menukarkan reward
        $response = $this->post(route('reward.redeem'), [
            'reward_id' => $reward->id,
        ]);

        // Memastikan pesan error muncul karena stok tidak tersedia
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Reward stock is not available.');
    }

    /**
     * Test tampilan detail transaksi.
     *
     * @return void
     */
    public function test_transaction_detail()
    {
        // Membuat pengguna
        $user = User::create([
            'role' => 'user',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phonenumber' => '0987654321',
            'location' => 'Some Address',
        ]);

        // Mensimulasikan pengguna yang sudah login
        $this->actingAs($user);

        // Membuat reward
        $reward = Reward::create([
            'name' => 'Vas Bunga Plastik',
            'description' => 'Vas bunga plastik ini terbuat dari bahan tahan lama.',
            'points_required' => 100,
            'stock' => 50,
            'category' => 'Hiasan',
        ]);

        // Membuat transaksi reward
        $transaction = RewardTransaction::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'points_used' => 100,
        ]);

        // Mengirimkan permintaan untuk melihat detail transaksi
        $response = $this->get(route('pointReward.transactionDetail', ['transaction' => $transaction->id]));

        // Memastikan tampilan detail transaksi ditampilkan
        $response->assertViewIs('pointReward.transactionDetail');
        $response->assertViewHas('transaction', $transaction);
    }
}
