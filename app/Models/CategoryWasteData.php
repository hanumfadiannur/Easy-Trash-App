<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryWasteData extends Model
{
    use HasFactory;

    protected $table = 'category_waste_data';

    protected $fillable = [
        'wasteDataID',
        'categoryID',
        'weight',
    ];

    // Relasi ke tabel waste_data (satu kategori data sampah terkait dengan satu data sampah)
    public function wasteData()
    {
        return $this->belongsTo(WasteData::class, 'wasteDataID');
    }

    // Relasi ke tabel waste_categories (satu kategori data sampah terkait dengan satu kategori)
    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class, 'categoryID');
    }
}
