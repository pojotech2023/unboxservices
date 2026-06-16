<?php
// app/Models/DeviceEvaluation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_mobile',
        'brand_id',
        'model_id',
        'variant_id',
        'laptop_brand_id',
        'laptop_model_id',
        'laptop_variant_id',
        'device_type',
        'answers',
        'estimated_price',
        'status',
        'otp_verified',
        'otp_verified_at',
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
        'answers' => 'array',
        'estimated_price' => 'decimal:2',
        'otp_verified' => 'boolean',
        'otp_verified_at' => 'datetime',
    ];

    // Relationships for Mobile
    public function brand() {
        return $this->belongsTo(MobileBrand::class, 'brand_id');
    }

    public function model() {
        return $this->belongsTo(MobileModel::class, 'model_id');
    }

    public function variant() {
        return $this->belongsTo(MobileVariant::class, 'variant_id');
    }

    // Relationships for Laptop
    public function laptopBrand() {
        return $this->belongsTo(LaptopBrand::class, 'laptop_brand_id');
    }

    public function laptopModel() {
        return $this->belongsTo(LaptopModel::class, 'laptop_model_id');
    }

    public function laptopVariant() {
        return $this->belongsTo(LaptopVariant::class, 'laptop_variant_id');
    }

    // Helper: Get parsed answers
    public function getParsedAnswersAttribute(): array
    {
        return is_array($this->answers) ? $this->answers : json_decode($this->answers, true) ?? [];
    }
}
