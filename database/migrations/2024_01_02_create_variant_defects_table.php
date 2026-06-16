<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_defects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobile_variant_id')->constrained('mobile_variants')->onDelete('cascade');
            $table->string('image');
            $table->string('description');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_defects');
    }
};
