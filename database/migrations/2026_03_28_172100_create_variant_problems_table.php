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
        Schema::create('variant_problems', function (Blueprint $table) {
    $table->id();
 $table->unsignedBigInteger('mobile_variant_id');
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
        Schema::dropIfExists('variant_problems');
    }
};
