<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaptopDeviceEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laptop_device_evaluations';

    protected $fillable = [
        // Customer
        'customer_name',
        'customer_mobile',
        'customer_email',

        // Device
        'laptop_brand_id',
        'laptop_model_id',
        'laptop_variant_id',

        // Evaluation
        'answers',
        'base_price',
        'total_deduction',
        'estimated_price',

        // Status & Admin
        'status',
        'admin_notes',

        // OTP
        'otp_verified',
        'otp_verified_at',

        // Address
        'pincode',
        'flat_no',
        'locality',
        'landmark',
        'city',
        'alternate_number',
        'address_type',
        'pickup_slot',
        'payment_method',
    ];

    protected $casts = [
        'answers'          => 'array',
        'base_price'       => 'decimal:2',
        'total_deduction'  => 'decimal:2',
        'estimated_price'  => 'decimal:2',
        'otp_verified'     => 'boolean',
        'otp_verified_at'  => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function brand(): BelongsTo
    {
        return $this->belongsTo(LaptopBrand::class, 'laptop_brand_id');
    }

    public function laptopModel(): BelongsTo
    {
        return $this->belongsTo(LaptopModel::class, 'laptop_model_id');
    }

    // backward compatibility (old code use pannina)
    public function model(): BelongsTo
    {
        return $this->laptopModel();
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(LaptopVariant::class, 'laptop_variant_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors (Evaluation Data)
    |--------------------------------------------------------------------------
    */

    public function getDeviceAgeAttribute()
    {
        return $this->answers['device_age'] ?? null;
    }

    public function getPhysicalConditionAttribute()
    {
        return $this->answers['physical_condition'] ?? [];
    }

    public function getPowerOnStatusAttribute()
    {
        return $this->answers['power_on'] ?? 'unknown';
    }

    public function getProcessorAttribute()
    {
        return $this->answers['processor'] ?? null;
    }

    public function getRamAttribute()
    {
        return $this->answers['ram'] ?? null;
    }

    public function getStorageAttribute()
    {
        return $this->answers['storage'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->estimated_price, 0);
    }

    public function getDefectsCountAttribute()
    {
        $physical = $this->answers['physical_condition'] ?? [];
        $deviceCondition = $this->answers['device_condition'] ?? [];

        $count = 0;

        if (is_array($physical)) {
            $count += count($physical);
        }

        if (is_array($deviceCondition)) {
            $count += count($deviceCondition);
        }

        return $count;
    }
}