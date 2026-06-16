<?php
// app/Models/LaptopSystemConfig.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopSystemConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'laptop_model_id',
        'config_type',
        'value',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Config types constant
    const TYPES = ['processor', 'ram', 'storage'];

    public function laptopModel()
    {
        return $this->belongsTo(LaptopModel::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('config_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('value');
    }
}