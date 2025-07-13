<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'dokumentasi';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agenda_id',
        'image_path',
        'caption',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Secara otomatis mengubah kolom image_path dari JSON (di database) 
        // menjadi array (di PHP) saat diakses, dan sebaliknya saat menyimpan.
        'image_path' => 'array',
    ];

    /**
     * Mendapatkan agenda yang terkait dengan dokumentasi.
     */
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}