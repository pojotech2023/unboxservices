<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileQuestion extends Model
{
    protected $fillable = [
        'question',
        'small_description',
        'yes_answer',
        'no_answer',
        'sort_order',
    ];
}
