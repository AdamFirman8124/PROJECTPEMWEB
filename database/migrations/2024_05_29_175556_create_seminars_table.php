<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('pembicaras', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembicara');
            $table->string('topik');
            $table->string('asal_instansi');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

        Schema::create('seminars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_seminar');
            $table->string('tanggal_seminar')->default(date('Y-m-d'));
            $table->string('lokasi_seminar');
            $table->string('google_map_link')->nullable();
            $table->string('gambar_seminar')->nullable();
            $table->boolean('is_paid')->nullable()->default(null);
            $table->date('start_registration');
            $table->date('end_registration');
            $table->integer('harga_seminar')->nullable();
            $table->unsignedBigInteger('pembicara_id');
            $table->foreign('pembicara_id')->references('id')->on('pembicaras');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        // Memastikan tabel 'seminars' dihapus terlebih dahulu karena memiliki foreign key.
        Schema::dropIfExists('seminars');
        // Kemudian hapus tabel 'pembicaras'.
        Schema::dropIfExists('pembicaras');
        Schema::enableForeignKeyConstraints();
    }
};

