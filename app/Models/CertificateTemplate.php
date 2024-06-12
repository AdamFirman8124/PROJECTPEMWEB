<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_path', 'seminar_id', 'access_time'];

    // Relasi ke Seminar
    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
}
