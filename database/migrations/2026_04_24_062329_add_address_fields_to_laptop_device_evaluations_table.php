<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laptop_device_evaluations', function (Blueprint $table) {
            // Address fields
            if (!Schema::hasColumn('laptop_device_evaluations', 'pincode')) {
                $table->string('pincode', 6)->nullable()->after('estimated_price');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'flat_no')) {
                $table->string('flat_no')->nullable()->after('pincode');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'locality')) {
                $table->string('locality')->nullable()->after('flat_no');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'landmark')) {
                $table->string('landmark')->nullable()->after('locality');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'city')) {
                $table->string('city')->nullable()->after('landmark');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'alternate_number')) {
                $table->string('alternate_number', 10)->nullable()->after('city');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'address_type')) {
                $table->enum('address_type', ['home', 'office', 'other'])->default('home')->after('alternate_number');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'pickup_slot')) {
                $table->string('pickup_slot')->nullable()->after('address_type');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'upi', 'bank'])->nullable()->after('pickup_slot');
            }
            // Ensure status column exists
            if (!Schema::hasColumn('laptop_device_evaluations', 'status')) {
                $table->string('status')->default('pending')->after('estimated_price');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'otp_verified')) {
                $table->boolean('otp_verified')->default(false)->after('status');
            }
            if (!Schema::hasColumn('laptop_device_evaluations', 'otp_verified_at')) {
                $table->timestamp('otp_verified_at')->nullable()->after('otp_verified');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laptop_device_evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'pincode','flat_no','locality','landmark','city',
                'alternate_number','address_type','pickup_slot','payment_method',
            ]);
        });
    }
};