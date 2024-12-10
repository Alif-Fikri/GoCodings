<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;

    protected $table = 'jawaban_siswa';

    protected $fillable = [
        'siswa_id',
        'soal_id',
        'jawaban_id',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Soal
    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    // Relasi ke Jawaban
    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class);
    }
}
