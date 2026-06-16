<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefectSection extends Model
{
    use HasFactory;
     protected $fillable = ['variant_defect_id', 'title', 'description', 'order'];
 
    public function images()
    {
        return $this->hasMany(DefectSectionImage::class)->orderBy('order');
    }
 
    public function defect()
    {
        return $this->belongsTo(VariantDefect::class, 'variant_defect_id');
    }
}
