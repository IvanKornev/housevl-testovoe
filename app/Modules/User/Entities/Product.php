<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = ['price' => 'integer'];
    protected $fillable = [];
}
