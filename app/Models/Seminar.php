<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Seminar extends Model
{
    protected $fillable = [
        'tanggal_seminar', 'lokasi_seminar', 'link_google_map', 'gambar_seminar', 'is_paid',
        'mulai_pendaftaran', 'akhir_pendaftaran', 'pembicara', 'asal_instansi', 'topik'
    ];

    public function up()
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_seminar');
            $table->string('lokasi_seminar');
            $table->string('google_map_link');
            $table->string('gambar_seminar');
            $table->date('start_registration');
            $table->date('end_registration');
            $table->string('pembicara');
            $table->string('asal_instansi');
            $table->string('topik');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }
}
