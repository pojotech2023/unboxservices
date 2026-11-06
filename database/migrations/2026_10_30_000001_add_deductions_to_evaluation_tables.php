<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Variant Questions
        Schema::table('variant_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('variant_questions', 'deduction_amount')) {
                $table->decimal('deduction_amount', 10, 2)->default(0)->after('no_answer');
            }
        });

        // 2. Variant Defects
        Schema::table('variant_defects', function (Blueprint $table) {
            if (!Schema::hasColumn('variant_defects', 'deduction_amount')) {
                $table->decimal('deduction_amount', 10, 2)->default(0)->after('description');
            }
        });

        // 3. Defect Section Images
        Schema::table('defect_section_images', function (Blueprint $table) {
            if (!Schema::hasColumn('defect_section_images', 'deduction_amount')) {
                $table->decimal('deduction_amount', 10, 2)->default(0)->after('description');
            }
        });

        // 4. Variant Problems
        Schema::table('variant_problems', function (Blueprint $table) {
            if (!Schema::hasColumn('variant_problems', 'deduction_amount')) {
                $table->decimal('deduction_amount', 10, 2)->default(0)->after('description');
            }
        });

        // 5. Variant Accessories
        Schema::table('variant_accessories', function (Blueprint $table) {
            if (!Schema::hasColumn('variant_accessories', 'deduction_amount')) {
                $table->decimal('deduction_amount', 10, 2)->default(0)->after('small_description');
            }
        });

        // 6. Device Evaluations
        Schema::table('device_evaluations', function (Blueprint $table) {
            if (!Schema::hasColumn('device_evaluations', 'base_price')) {
                $table->decimal('base_price', 10, 2)->nullable()->after('answers');
            }
            if (!Schema::hasColumn('device_evaluations', 'total_deduction')) {
                $table->decimal('total_deduction', 10, 2)->default(0)->after('base_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('variant_questions', function (Blueprint $table) {
            if (Schema::hasColumn('variant_questions', 'deduction_amount')) {
                $table->dropColumn('deduction_amount');
            }
        });

        Schema::table('variant_defects', function (Blueprint $table) {
            if (Schema::hasColumn('variant_defects', 'deduction_amount')) {
                $table->dropColumn('deduction_amount');
            }
        });

        Schema::table('defect_section_images', function (Blueprint $table) {
            if (Schema::hasColumn('defect_section_images', 'deduction_amount')) {
                $table->dropColumn('deduction_amount');
            }
        });

        Schema::table('variant_problems', function (Blueprint $table) {
            if (Schema::hasColumn('variant_problems', 'deduction_amount')) {
                $table->dropColumn('deduction_amount');
            }
        });

        Schema::table('variant_accessories', function (Blueprint $table) {
            if (Schema::hasColumn('variant_accessories', 'deduction_amount')) {
                $table->dropColumn('deduction_amount');
            }
        });

        Schema::table('device_evaluations', function (Blueprint $table) {
            if (Schema::hasColumn('device_evaluations', 'base_price')) {
                $table->dropColumn('base_price');
            }
            if (Schema::hasColumn('device_evaluations', 'total_deduction')) {
                $table->dropColumn('total_deduction');
            }
        });
    }
};
