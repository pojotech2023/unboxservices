<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('small_description')->nullable();
            $table->string('yes_answer')->default('Yes');
            $table->string('no_answer')->default('No');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_questions');
    }
};
