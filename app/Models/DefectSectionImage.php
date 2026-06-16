<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefectSectionImage extends Model
{
    use HasFactory;
      protected $fillable = ['defect_section_id', 'image', 'description', 'order'];
 
    public function section()
    {
        return $this->belongsTo(DefectSection::class, 'defect_section_id');
    }
}
