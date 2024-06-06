<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['seminar_id', 'user_id']; // Attribut yang dapat diisi secara massal

    // Relasi dengan model Seminar
    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
