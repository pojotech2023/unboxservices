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
        Schema::create('variant_accessories', function (Blueprint $table) {
            $table->id();
            $table->string('description');          // e.g. "Original Charger of Device"
            $table->string('small_description')->nullable(); // optional sub-text
            $table->string('image');                // stored path
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_accessories');
    }
};
