<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wasteCategory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $table = 'waste_category';

    protected $fillable = [
        'type',
    ];

    public function categoryWasteData()
    {
        return $this->hasMany(CategoryWasteData::class, 'categoryID');
    }
}
