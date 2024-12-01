<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel maps_user
    public function mapsUser()
    {
        return $this->hasOne(MapsUser::class, 'user_id');
    }

    // Relasi ke tabel maps_recycleorg
    public function mapsRecycleOrg()
    {
        return $this->hasOne(MapsRecycleOrg::class, 'user_id');
    }

    // Relasi ke RewardTransaction
    public function rewardTransactions()
    {
        return $this->hasMany(RewardTransaction::class);
    }
}
