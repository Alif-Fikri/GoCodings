<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';  // Nama tabel yang sesuai dengan database Anda
    protected $fillable = [
        'nama', 'email', 'asal_sekolah', 'jenjang_pendidikan',
    ];

    public function guru()
    {
        return $this->hasOne(Guru::class, 'email', 'email'); // Relasi berdasarkan user_id
    }
    

}

