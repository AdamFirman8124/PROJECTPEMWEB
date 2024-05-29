<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsPaidOnSeminarsTable extends Migration
{
    public function up()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->boolean('is_paid')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false)->change(); // Kembali ke pengaturan sebelumnya jika migrasi di-rollback
        });
    }
}
