<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobile_brand_id')->constrained('mobile_brands')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable(); // phone image path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_models');
    }
};
