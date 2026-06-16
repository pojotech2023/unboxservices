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
            if (!Schema::hasColumn('device_evaluations', 'status')) {
                $table->string('status')->nullable()->after('estimated_price');
            }

            if (!Schema::hasColumn('device_evaluations', 'otp_verified')) {
                $table->boolean('otp_verified')->default(false)->after('status');
            }

            if (!Schema::hasColumn('device_evaluations', 'otp_verified_at')) {
                $table->timestamp('otp_verified_at')->nullable()->after('otp_verified');
            }

            if (!Schema::hasColumn('device_evaluations', 'pincode')) {
                $table->string('pincode', 10)->nullable()->after('otp_verified_at');
            }

            if (!Schema::hasColumn('device_evaluations', 'flat_no')) {
                $table->string('flat_no')->nullable()->after('pincode');
            }

            if (!Schema::hasColumn('device_evaluations', 'locality')) {
                $table->string('locality')->nullable()->after('flat_no');
            }

            if (!Schema::hasColumn('device_evaluations', 'landmark')) {
                $table->string('landmark')->nullable()->after('locality');
            }

            if (!Schema::hasColumn('device_evaluations', 'city')) {
                $table->string('city')->nullable()->after('landmark');
            }

            if (!Schema::hasColumn('device_evaluations', 'alternate_number')) {
                $table->string('alternate_number', 20)->nullable()->after('city');
            }

            if (!Schema::hasColumn('device_evaluations', 'address_type')) {
                $table->string('address_type', 20)->nullable()->after('alternate_number');
            }

            if (!Schema::hasColumn('device_evaluations', 'pickup_slot')) {
                $table->string('pickup_slot')->nullable()->after('address_type');
            }

            if (!Schema::hasColumn('device_evaluations', 'payment_method')) {
                $table->string('payment_method', 20)->nullable()->after('pickup_slot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_evaluations', function (Blueprint $table) {
            foreach ([
                'payment_method',
                'pickup_slot',
                'address_type',
                'alternate_number',
                'city',
                'landmark',
                'locality',
                'flat_no',
                'pincode',
                'otp_verified_at',
                'otp_verified',
                'status',
            ] as $column) {
                if (Schema::hasColumn('device_evaluations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
