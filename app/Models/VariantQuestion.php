<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantQuestion extends Model
{
    protected $fillable = [
        'mobile_variant_id',
        'question',
        'small_description',
        'yes_answer',
        'no_answer',
        'sort_order',
    ];

    public function variant()
    {
        return $this->belongsTo(MobileVariant::class, 'mobile_variant_id');
    }
}
