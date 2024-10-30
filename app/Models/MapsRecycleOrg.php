<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapsRecycleOrg extends Model
{
    use HasFactory;

    protected $table = 'maps_recycleorg';

    protected $fillable = [
        'user_id', // Use user_id since it's the same as recycleorg_id
        'address',
        'latitude',
        'longitude',
    ];

    public function recycleOrg()
    {
        return $this->belongsTo(User::class, 'user_id'); // Same foreign key
    }
}
