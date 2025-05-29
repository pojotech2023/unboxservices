<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_img',
        'location',
        'value',
        'duration',
        'settled_amnt',
        'pending_amnt',
        'expense',
        'status',
        'is_inactive'
    ];

    public function customer()
    {
        return $this->hasMany(Customer::class, 'site_id');
    }

    public function otherUtilities()
    {
        return $this->hasMany(OtherUtilities::class, 'site_id');
    }

    public function otherUtilitiesSub()
    {
        return $this->hasMany(otherUtilitiesSub::class, 'site_id');
    }

    public function materialRequests()
    {
        return $this->hasMany(MaterialRequest::class);
    }

    public function materialOrders()
    {
        return $this->hasMany(MaterialOrder::class);
    }

    public function materialPayments()
    {
        return $this->hasMany(MaterialPayment::class);
    }

    public function wages()
    {
        return $this->hasMany(Wages::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function subcontractor()
    {
        return $this->hasMany(Subcontractor::class);
    }
}
