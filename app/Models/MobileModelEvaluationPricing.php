<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileModelEvaluationPricing extends Model
{
    protected $fillable = [
        'mobile_model_id',
        'full_positive_price',
        'full_positive_description',
        'full_negative_price',
        'full_negative_description',
        'mixed_price',
        'mixed_description',
    ];

    public function model()
    {
        return $this->belongsTo(MobileModel::class, 'mobile_model_id');
    }
}
