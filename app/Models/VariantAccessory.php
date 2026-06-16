<?php
// app/Models/VariantAccessory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantAccessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'small_description',
        'image',
        'sort_order',
    ];
}
