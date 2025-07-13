<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'title',
        'description',
        'meeting_date',
        'meeting_time',
        'user_id', // Foreign key ke tabel users
    ];

    // Casting atribut untuk tipe data tertentu
    protected $casts = [
        'meeting_date' => 'date',
        'meeting_time' => 'datetime:H:i:s', // Mengonversi ke objek Carbon untuk waktu
    ];

    // Definisi relasi: Satu agenda dibuat oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisi relasi: Satu agenda memiliki banyak Notula
    public function notula()
    {
        return $this->hasOne(Notula::class, 'agenda_id');
    }

    // Definisi relasi: Satu agenda memiliki banyak Presensi
    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    // Definisi relasi: Satu agenda memiliki banyak Dokumentasi
    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class);
    }
}
