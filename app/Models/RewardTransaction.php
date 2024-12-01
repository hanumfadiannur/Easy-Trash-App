<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardTransaction extends Model
{
    use HasFactory;

    protected $table = 'reward_transactions';

    protected $fillable = [
        'user_id',
        'reward_id',
        'points_used',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Reward
    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
