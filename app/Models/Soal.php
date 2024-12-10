<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = ['soal', 'guru_id', 'asal_sekolah'];

    public function jawabans()
    {
        return $this->hasMany(Jawaban::class);
    }
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    public function siswa()
    {
        return $this->belongsTo(User::class, 'asal_sekolah');
    }
}
