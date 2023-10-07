<?php

namespace App\Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Catalog\Database\Factories\ProductCharacteristicFactory;

class ProductCharacteristic extends Model
{
    use HasFactory;

    protected $fillable = [];
    public $timestamps = false;

    protected static function newFactory(): Factory
    {
        return ProductCharacteristicFactory::new();
    }
}
