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
        Schema::create('seminar_materials', function (Blueprint $table) {
            $table->id('material_id'); // Primary key, auto-increment
            // $table->unsignedBigInteger('seminar_id'); // Foreign key to Seminars
            $table->string('file_path'); // Path to the material file
            $table->string('description'); // Description of the material
            
            // Foreign key constraint
            //$table->foreign('seminar_id')->references('id')->on('seminars')->onDelete('cascade');

            $table->timestamps(); // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_materials');
    }
};
