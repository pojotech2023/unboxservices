<?php
// app/Models/LaptopQuestionOption.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopQuestionOption extends Model {
    use HasFactory;
    
    protected $fillable = ['laptop_question_id','label','icon_emoji','option_image','deduction','sort_order'];
    protected $casts = ['deduction' => 'integer', 'sort_order' => 'integer'];
 
    public function question() {
        return $this->belongsTo(LaptopQuestion::class, 'laptop_question_id');
    }
 
    public function getImageUrlAttribute(): ?string {
        if ($this->option_image) {
            return asset('storage/' . $this->option_image);
        }
        return null;
    }
}