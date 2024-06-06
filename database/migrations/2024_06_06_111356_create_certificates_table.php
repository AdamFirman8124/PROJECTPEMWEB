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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminar_id')->constrained('seminars');
            $table->date('download_start_date');
            $table->timestamp('created_at')->useCurrent();
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_name');
            // tambahkan field lain sesuai kebutuhan
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
