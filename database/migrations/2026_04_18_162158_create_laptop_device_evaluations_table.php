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
        Schema::create('laptop_device_evaluations', function (Blueprint $table) {
            $table->id();
            
            // Customer Details
            $table->string('customer_name');
            $table->string('customer_mobile', 15);
            $table->string('customer_email')->nullable();
            
            // Device Info
            $table->foreignId('laptop_brand_id')->constrained('laptop_brands')->onDelete('cascade');
            $table->foreignId('laptop_model_id')->constrained('laptop_models')->onDelete('cascade');
            $table->foreignId('laptop_variant_id')->nullable()->constrained('laptop_variants')->onDelete('set null');
            
            // Evaluation Answers (JSON)
            $table->json('answers')->comment('All evaluation answers including power_on, processor, ram, storage, conditions, etc.');
            
            // Pricing
            $table->decimal('base_price', 12, 2);
            $table->decimal('total_deduction', 12, 2)->default(0);
            $table->decimal('estimated_price', 12, 2);
            
            // Status
            $table->enum('status', ['pending', 'verified', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            
            // OTP Verification
            $table->boolean('otp_verified')->default(false);
            $table->timestamp('otp_verified_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('customer_mobile');
            $table->index('status');
            $table->index('created_at');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptop_device_evaluations');
    }
};
