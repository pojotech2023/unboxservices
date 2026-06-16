<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantDefect extends Model
{
    protected $fillable = [
        'mobile_variant_id',
        'image',
        'description',
        'sort_order',
    ];

    public function variant()
    {
        return $this->belongsTo(MobileVariant::class, 'mobile_variant_id');
    }
     public function sections()
    {
        return $this->hasMany(DefectSection::class, 'variant_defect_id')->orderBy('order');
    }
 

}
