<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->string('file_path')->nullable(); // Tambahkan kolom file_path
        });
    }

    public function down()
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn('file_path'); // Hapus kolom jika migrasi di-rollback
        });
    }
};