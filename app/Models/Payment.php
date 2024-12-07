<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['name', 'parent_id', 'account_number', 'description', 'is_active'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function parent()
    {
        return $this->belongsTo(Self::class, 'parent_id');
    }
}
