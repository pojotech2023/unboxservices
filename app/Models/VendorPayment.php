<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'payment',
        'date',
        'payment_mode'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
