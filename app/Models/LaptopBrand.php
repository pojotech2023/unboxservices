<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LaptopBrand extends Model
{
    protected $fillable = ['name', 'slug', 'logo'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->slug = Str::slug($m->name));
        static::updating(fn($m) => $m->slug = Str::slug($m->name));
    }

    public function models()
    {
        return $this->hasMany(LaptopModel::class);
    }
}