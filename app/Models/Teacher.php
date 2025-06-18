<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // Kolom-kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'nip',
    ];
}
