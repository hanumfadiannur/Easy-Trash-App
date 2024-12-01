<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteData extends Model
{
    use HasFactory;

    protected $table = 'waste_data';

    protected $fillable = [
        'wasteRequestID',
        'userID',
        'total_weight',
        'points',
    ];

    // Relasi ke tabel waste_requests (satu data sampah terkait dengan satu permintaan)
    public function wasteRequest()
    {
        return $this->belongsTo(WasteRequest::class, 'wasteRequestID');
    }

    // Relasi ke tabel users (satu data sampah milik satu pengguna)
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    // Relasi ke tabel category_waste_data (satu data sampah bisa memiliki banyak kategori)
    public function categoryWasteData()
    {
        return $this->hasMany(CategoryWasteData::class, 'wasteDataID');
    }

    public function categories()
    {
        return $this->belongsToMany(WasteCategory::class, 'category_waste_data', 'wasteDataID', 'categoryID')
            ->withPivot('weight');
    }
}
