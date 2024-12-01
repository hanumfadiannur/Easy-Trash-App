<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wasteRequest extends Model
{
    use HasFactory;
    protected $table = 'waste_request'; // Nama tabel di database

    // Definisikan atribut yang dapat diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'recycleorgID',
        'status',
        'expiryDate'
    ];

    // Relasi ke model User (pengguna yang membuat permintaan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model User (recycleorg yang menerima permintaan)
    public function recycleOrg()
    {
        return $this->belongsTo(User::class, 'recycleorgID');
    }

    // Method untuk menghitung expiryDate (misalnya 2 hari setelah created_at)
    // public function setExpiryDateAttribute()
    // {
    //     $this->attributes['expiryDate'] = now()->addDays(2);
    // }

    public function wasteData()
    {
        return $this->hasMany(WasteData::class, 'wasteRequestID', 'id');
    }

    // Relationship to categories
    public function categories()
    {
        return $this->belongsToMany(WasteCategory::class, 'category_waste_data', 'wasteDataID', 'categoryID')
            ->withPivot('weight')
        ;
    }
}
