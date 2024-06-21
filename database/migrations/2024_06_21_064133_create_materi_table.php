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
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminar_id')->constrained()->onDelete('cascade');
            $table->string('judul_materi');
            $table->timestamps();
        });

        if (!Schema::hasTable('materi_files')) {
            Schema::create('materi_files', function (Blueprint $table) {
                $table->id();
                $table->foreignId('materi_id')->constrained('materi')->onDelete('cascade');
                $table->string('file_path');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('materi_files', function (Blueprint $table) {
            $table->dropForeign(['materi_id']);
        });
        Schema::dropIfExists('materi_files');
        Schema::dropIfExists('materi');
    }
};
