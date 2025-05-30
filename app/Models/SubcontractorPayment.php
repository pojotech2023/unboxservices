<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcontractorPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcontractor_type',
        'name',
        'payment',
        'date',
        'payment_mode',
        'created_by',
        'updated_by'
    ];

}
