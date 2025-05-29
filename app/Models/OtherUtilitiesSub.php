<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherUtilitiesSub extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'amount',
        'remarks',
        'image'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
