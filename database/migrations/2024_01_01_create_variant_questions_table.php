<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobile_variant_id')->constrained('mobile_variants')->onDelete('cascade');
            $table->string('question');
            $table->string('small_description')->nullable();
            $table->string('yes_answer')->default('Yes');
            $table->string('no_answer')->default('No');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_questions');
    }
};
