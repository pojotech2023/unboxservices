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
       
        Schema::create('laptop_system_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laptop_model_id')->constrained()->onDelete('cascade');
            $table->string('config_type'); // 'processor' | 'ram' | 'storage'
            $table->string('value');        // e.g. 'Intel Core i3', '8GB', '512GB SSD'
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptop_system_configs');
    }
};
