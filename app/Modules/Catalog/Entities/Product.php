<?php

namespace App\Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Catalog\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }
}
