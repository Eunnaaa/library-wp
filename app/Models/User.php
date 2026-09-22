<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'image',
        'password',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_user');
    }

    public function pinjams()
    {
        return $this->hasMany(Pinjam::class, 'id_user');
    }

    public function temp()
    {
        return $this->hasMany(Temp::class, 'id_user');
    }

    public function totalBooking()
    {
        return BookingDetail::whereIn('id_booking', function ($query) {
            $query->select('id_booking')
                ->from('booking')
                ->where('id_user', $this->id);
        })->count();
    }

    public function totalSedangPinjam()
    {
        return PinjamDetail::whereIn('no_pinjam', function ($query) {
            $query->select('no_pinjam')
                ->from('pinjam')
                ->where('id_user', $this->id);
        })->where('status', 'Pinjam')->count();
    }
}
