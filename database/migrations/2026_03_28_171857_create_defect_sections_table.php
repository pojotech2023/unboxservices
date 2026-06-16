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
        Schema::create('defect_sections', function (Blueprint $table) {
    $table->id();
    $table->foreignId('variant_defect_id')->constrained('variant_defects')->onDelete('cascade');
    $table->string('title');
    $table->string('description')->nullable();
    $table->unsignedInteger('order')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defect_sections');
    }
};
