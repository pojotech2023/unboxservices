<?php
// app/Models/MobileVariant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile_model_id',
        'memory',
        'price',
        'stock',
    ];

    public function mobileModel()
    {
        return $this->belongsTo(MobileModel::class, 'mobile_model_id');
    }
     public function model()
    {
        return $this->belongsTo(MobileModel::class, 'mobile_model_id');
    }
 
    public function questions()
    {
        return $this->hasMany(VariantQuestion::class, 'mobile_variant_id')->orderBy('sort_order');
    }
 
    public function defects()
    {
        return $this->hasMany(VariantDefect::class, 'mobile_variant_id')->orderBy('sort_order');
    }
}