<?php
// create_mobile_variants_table migration

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobile_model_id')->constrained('mobile_models')->onDelete('cascade');
            $table->string('memory');        // e.g. "8GB"
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_variants');
    }
};