<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LaptopModel extends Model
{
    protected $fillable = ['laptop_brand_id', 'name', 'slug', 'image', 'price'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->slug = Str::slug($m->name));
        static::updating(fn($m) => $m->slug = Str::slug($m->name));
    }

    public function brand()
    {
        return $this->belongsTo(LaptopBrand::class, 'laptop_brand_id');
    }

    public function variants()
    {
        return $this->hasMany(LaptopVariant::class);
    }
    public function systemConfigs()
{
    return $this->hasMany(\App\Models\LaptopSystemConfig::class, 'laptop_model_id');
}
 public function evaluationPricing()
{
    return $this->hasOne(LaptopModelEvaluationPricing::class, 'laptop_model_id');
}
// Also add to SellLaptopController.php — systemConfig() method:
 
}