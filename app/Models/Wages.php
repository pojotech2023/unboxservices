<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wages extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'category',
        'amount',
        'date'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
