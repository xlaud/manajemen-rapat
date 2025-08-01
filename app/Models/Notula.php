<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notula extends Model
{
    use HasFactory;

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'title',
        'description',
        'agenda_id',
        'user_id',
    ];

    // Definisi relasi: Satu notula milik satu Agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    // Definisi relasi: Satu notula ditulis oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
