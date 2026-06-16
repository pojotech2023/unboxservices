<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_model_evaluation_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobile_model_id')->unique()->constrained('mobile_models')->onDelete('cascade');
            $table->decimal('full_positive_price', 10, 2);
            $table->string('full_positive_description')->nullable();
            $table->decimal('full_negative_price', 10, 2);
            $table->string('full_negative_description')->nullable();
            $table->decimal('mixed_price', 10, 2);
            $table->string('mixed_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_model_evaluation_pricings');
    }
};
