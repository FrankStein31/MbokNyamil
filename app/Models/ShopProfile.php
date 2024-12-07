<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProfile extends Model
{
    protected $table = 'shop_profiles';

    protected $fillable = ['name', 'address', 'email', 'phone'];
}
