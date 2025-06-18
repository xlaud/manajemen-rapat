<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi'; // Pastikan nama tabel benar, karena bukan 'presensis'

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',   // Foreign key ke tabel users (guru yang presensi)
        'agenda_id', // Foreign key ke tabel agendas (agenda rapat terkait)
        'status',
        'notes',
        'presensi_time',
    ];

    // Casting atribut untuk tipe data Carbon (objek tanggal dan waktu)
    protected $casts = [
        'presensi_time' => 'datetime',
    ];

    // Definisi relasi: Satu presensi milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisi relasi: Satu presensi terkait dengan satu Agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
