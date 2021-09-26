<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSale extends Model
{
    use HasFactory;

    protected $fillable = ['totalValue', 'codeSale', 'user_id'];
}
