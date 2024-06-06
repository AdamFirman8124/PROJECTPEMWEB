<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seminar_id',
        'identitas',
        'name',
        'email',
        'phone',
        'instansi',
        'info'
    ];
}

