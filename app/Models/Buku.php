<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'judul_buku',
        'id_kategori',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'dipinjam',
        'dibooking',
        'image',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function booking_detail()
    {
        return $this->hasMany(BookingDetail::class, 'id_buku');
    }

    public function pinjam_detail()
    {
        return $this->hasMany(PinjamDetail::class, 'id_buku');
    }

    public function temp()
    {
        return $this->hasMany(Temp::class, 'id_buku');
    }
}
