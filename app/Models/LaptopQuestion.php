<?php
// app/Models/LaptopQuestion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopQuestion extends Model {
    use HasFactory;
    
    protected $fillable = ['question','small_description','question_group','input_type','sort_order','is_active'];
    protected $casts    = ['is_active' => 'boolean', 'sort_order' => 'integer'];
 
    public function options() {
        return $this->hasMany(LaptopQuestionOption::class, 'laptop_question_id')->orderBy('sort_order');
    }
    
    public function scopeActive($q) { 
        return $q->where('is_active', true); 
    }
    
    public function scopeOfGroup($q, $group) { 
        return $q->where('question_group', $group); 
    }
    
    public function scopeOrdered($q) { 
        return $q->orderBy('sort_order'); 
    }
}