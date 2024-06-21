<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $fillable = ['seminar_id', 'judul_materi', 'file_path', 'created_at', 'updated_at'];

    // Definisikan relasi ke Seminar
    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
}
