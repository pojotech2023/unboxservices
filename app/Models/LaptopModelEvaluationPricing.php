<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaptopModelEvaluationPricing extends Model
{
    protected $table = 'laptop_model_evaluation_pricings';

    protected $fillable = [
        'laptop_model_id',
        'full_positive_price',
        'full_positive_description',
        'full_negative_price',
        'full_negative_description',
        'mixed_price',
        'mixed_description',
    ];

       protected $casts = [
        'full_positive_price' => 'float',
        'full_negative_price' => 'float',
        'mixed_price'         => 'float',
    ];
    public function laptopModel()
    {
        return $this->belongsTo(LaptopModel::class, 'laptop_model_id');
    }
}