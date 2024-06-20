<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembicara extends Model
{
    use HasFactory;

    protected $table = 'pembicaras';

    protected $fillable = [
        'nama_pembicara',
        'topik',
        'asal_instansi',
        'seminar_id'
    ];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    public function seminars()
    {
        return $this->hasMany(Seminar::class, 'pembicara_id');
    }
}
