<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit jika berbeda dari konvensi
    protected $table = 'presensi';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'agenda_id',
        'status',
        'keterangan',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Setiap data presensi dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Agenda.
     * Setiap data presensi dimiliki oleh satu Agenda.
     */
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
