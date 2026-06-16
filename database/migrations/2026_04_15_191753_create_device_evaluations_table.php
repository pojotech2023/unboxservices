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
        Schema::create('device_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_mobile');
            
            // Mobile fields
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            
            // Laptop fields
            $table->unsignedBigInteger('laptop_brand_id')->nullable();
            $table->unsignedBigInteger('laptop_model_id')->nullable();
            $table->unsignedBigInteger('laptop_variant_id')->nullable();
            
            // Device type: 'mobile' or 'laptop'
            $table->enum('device_type', ['mobile', 'laptop'])->default('mobile');
            
            // All answers stored as JSON
            $table->text('answers')->nullable();
            
            $table->decimal('estimated_price', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_evaluations');
    }
};
