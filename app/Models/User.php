<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Agenda;
use App\Models\Notula;
use App\Models\Presensi;
use App\Models\Dokumentasi;


class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Penting: kolom 'role' untuk membedakan admin dan guru
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
    ];

    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    public function notulas()
    {
        return $this->hasMany(Notula::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class);
    }
}
