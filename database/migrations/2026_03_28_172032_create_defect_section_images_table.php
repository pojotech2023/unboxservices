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
       Schema::create('defect_section_images', function (Blueprint $table) {
    $table->id();
    $table->foreignId('defect_section_id')->constrained('defect_sections')->onDelete('cascade');
    $table->string('image');
    $table->string('description');
    $table->unsignedInteger('order')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defect_section_images');
    }
};
