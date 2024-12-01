<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $table = 'rewards';

    protected $fillable = [
        'name',
        'description',
        'points_required',
        'stock',
        'category',
    ];

    // Relasi ke RewardTransaction
    public function rewardTransactions()
    {
        return $this->hasMany(RewardTransaction::class);
    }
}
