<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\RewardTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function rewardAndPoint()
    {
        $user = User::find(Auth::user()->id);
        $rewards = Reward::all(); // Ambil semua reward dari tabel rewards

        $redeemedRewards = $user->rewardTransactions()->with('reward')->get(); // Reward yang sudah ditukar

        // Hitung total reward yang telah ditukar oleh user
        $redeemedCount = $redeemedRewards->count();

        return view('pointReward.pointReward', [
            'user' => $user,
            'rewards' => $rewards,
            'redeemedRewards' => $redeemedRewards,
            'redeemedCount' => $redeemedCount, // Tambahkan jumlah reward yang telah ditukar
        ]);
    }

    // Method untuk menukar reward
    public function redeemReward(Request $request)
    {
        $user = User::find(Auth::user()->id); // Ambil data user yang login
        $rewardId = $request->input('reward_id'); // ID reward yang ditukar
        $reward = Reward::findOrFail($rewardId); // Ambil data reward berdasarkan ID

        // Cek apakah user memiliki cukup poin
        if ($user->points < $reward->points_required) {
            return redirect()->back()->with('error', 'Poin tidak cukup untuk menukar reward ini.'); // Tampilkan pesan error
        }

        // Cek stok reward
        if ($reward->stock <= 0) {
            return redirect()->back()->with('error', 'Stok reward tidak tersedia.'); // Tampilkan pesan error
        }

        // Kurangi poin user
        $user->points -= $reward->points_required;
        $user->save();

        // Kurangi stok reward
        $reward->stock -= 1;
        $reward->save();

        // Simpan transaksi reward
        $transaction = $user->rewardTransactions()->create([
            'reward_id' => $reward->id,
            'user_id' => $user->id,
            'points_used' => $reward->points_required,
        ]);

        // Redirect ke halaman detail transaksi setelah berhasil menyimpan
        return redirect()->route('pointReward.transactionDetail', $transaction->id)->with('success', 'Points Successfully Exchanged.');
    }

    public function transactionDetail($transactionId)
    {
        // Ambil data transaksi berdasarkan ID
        $transaction = RewardTransaction::with(['reward', 'user'])->findOrFail($transactionId);

        // Kirim data transaksi ke view
        return view('pointReward.transactionDetail', compact('transaction'));
    }
}
