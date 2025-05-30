<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcontractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'subcontractor_type',
        'name',
        'date',
        'amount',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
