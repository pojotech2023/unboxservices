<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
  /**
     * Run the migrations.
     */
return new class extends Migration {
    public function up(): void {
        Schema::create('laptop_questions', function (Blueprint $t) {
            $t->id();
            $t->string('question');
            $t->string('small_description')->nullable();
            $t->enum('question_group', ['additional_features','device_condition','screen_condition','accessories']);
            $t->enum('input_type', ['radio','multi_select'])->default('radio');
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
 
        Schema::create('laptop_question_options', function (Blueprint $t) {
            $t->id();
            $t->foreignId('laptop_question_id')->constrained()->cascadeOnDelete();
            $t->string('label');
            $t->string('icon_emoji')->nullable();       // kept for backward compat, now optional
            $t->string('option_image')->nullable();     // NEW: stores uploaded image path
            $t->unsignedInteger('deduction')->default(0);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('laptop_question_options');
        Schema::dropIfExists('laptop_questions');
    }
};

