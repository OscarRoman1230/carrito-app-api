<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProducts extends Model
{
    use HasFactory;

    protected $fillable = ['user_sale_id', 'product_id'];
}
