<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_seminar', 'lokasi_seminar', 'google_map_link', 'gambar_seminar', 'is_paid',
        'start_registration', 'end_registration', 'pembicara', 'asal_instansi', 'topik'
    ];

    // Definisikan relasi ke CertificateTemplate
    public function certificateTemplate()
    {
        return $this->hasOne(CertificateTemplate::class);
    }

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
