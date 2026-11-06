<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantProblem extends Model
{
    use HasFactory;
     protected $fillable = ['variant_id', 'mobile_variant_id', 'image', 'description', 'deduction_amount', 'order'];
 
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
