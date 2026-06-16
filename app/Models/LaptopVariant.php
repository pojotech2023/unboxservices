<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaptopVariant extends Model
{
    protected $fillable = ['laptop_model_id', 'storage', 'ram', 'price'];

    public function model()
    {
        return $this->belongsTo(LaptopModel::class, 'laptop_model_id');
    }
}