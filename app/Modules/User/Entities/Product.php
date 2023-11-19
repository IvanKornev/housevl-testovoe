<?php

namespace App\Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

final class Product extends Model
{
    protected $casts = ['price' => 'integer'];
    protected $fillable = [];
}
