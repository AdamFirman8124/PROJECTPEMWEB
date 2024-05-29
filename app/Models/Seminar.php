<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $fillable = [
        'tanggal_seminar', 'lokasi_seminar', 'link_google_map', 'gambar_seminar', 'is_paid',
        'mulai_pendaftaran', 'akhir_pendaftaran', 'pembicara', 'asal_instansi', 'topik'
    ];
}

