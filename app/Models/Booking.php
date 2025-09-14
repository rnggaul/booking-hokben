<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking'; // nama tabel sesuai DB

    protected $fillable = [
        'ruangan',
        'divisi',
        'waktuMulai',
        'waktuSelesai',
        'status',
    ];
    public $timestamps = false; 

}
