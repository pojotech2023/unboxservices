<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'mobile_no',
        'subject',
        'total_amount'
    ];

    public function quotationDetail()
    {
        return $this->hasMany(QuotationDetail::class);
    }
}
