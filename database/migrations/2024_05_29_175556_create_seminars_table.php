<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_seminar');
            $table->string('lokasi_seminar');
            $table->string('google_map_link')->nullable();
            $table->string('gambar_seminar')->nullable();
            $table->boolean('is_paid')->nullable()->default(null);
            $table->date('start_registration');
            $table->date('end_registration');
            $table->string('pembicara');
            $table->string('asal_instansi');
            $table->string('topik');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seminars');
    }
};
