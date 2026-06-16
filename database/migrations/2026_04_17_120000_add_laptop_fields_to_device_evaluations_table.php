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
        Schema::table('device_evaluations', function (Blueprint $table) {
            // Make existing columns nullable (they're for mobile)
            $table->unsignedBigInteger('brand_id')->nullable()->change();
            $table->unsignedBigInteger('model_id')->nullable()->change();
            $table->unsignedBigInteger('variant_id')->nullable()->change();
            
            // Add laptop-specific fields
            $table->unsignedBigInteger('laptop_brand_id')->nullable()->after('variant_id');
            $table->unsignedBigInteger('laptop_model_id')->nullable()->after('laptop_brand_id');
            $table->unsignedBigInteger('laptop_variant_id')->nullable()->after('laptop_model_id');
            $table->enum('device_type', ['mobile', 'laptop'])->default('mobile')->after('laptop_variant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'laptop_brand_id',
                'laptop_model_id', 
                'laptop_variant_id',
                'device_type'
            ]);
        });
    }
};
