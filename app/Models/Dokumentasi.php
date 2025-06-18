<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi'; // Pastikan nama tabel benar, karena bukan 'dokumentasis'

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'title',
        'description',
        'file_path',   // Path ke file yang diunggah
        'agenda_id',   // Foreign key ke tabel agendas (opsional, bisa null)
        'user_id',     // Foreign key ke tabel users (siapa yang mengunggah)
    ];

    // Definisi relasi: Satu dokumentasi mungkin terkait dengan satu Agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    // Definisi relasi: Satu dokumentasi diunggah oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
