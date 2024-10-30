<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan database
    protected $table = 'bank_sampah';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_bank_sampah',
        'lokasi',
        'latitude',
        'longitude',
    ];
}
