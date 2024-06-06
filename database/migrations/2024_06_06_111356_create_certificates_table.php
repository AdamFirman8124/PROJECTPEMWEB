<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminar_id')->constrained('seminars');
            $table->date('download_start_date');
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_name');
            $table->timestamps(); // Tambahkan timestamps di sini
            // tambahkan field lain sesuai kebutuhan
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}

