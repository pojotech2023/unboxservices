<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MobileModel extends Model
{
    protected $fillable = ['mobile_brand_id', 'name', 'image', 'slug'];

    public function brand()
    {
        return $this->belongsTo(MobileBrand::class, 'mobile_brand_id');
    }

    public function variants()
    {
        return $this->hasMany(MobileVariant::class, 'mobile_model_id');
    }

    public function evaluationPricing()
    {
        return $this->hasOne(MobileModelEvaluationPricing::class, 'mobile_model_id');
    }

    // 🔥 Automatic Slug Generator
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}