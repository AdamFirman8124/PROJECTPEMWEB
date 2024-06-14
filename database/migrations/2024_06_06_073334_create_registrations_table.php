<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('registrations')) {
            Schema::create('registrations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('seminar_id');
                $table->string('identitas');
                $table->string('name');
                $table->string('email');
                $table->string('phone');
                $table->string('instansi');
                $table->string('info');
                $table->enum('status', ['Belum Diverifikasi', 'Sudah diverifikasi'])->default('Belum diverifikasi');
                $table->string('bukti_bayar')->nullable();
                $table->timestamps();
            
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('seminar_id')->references('id')->on('seminars')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
    
};
