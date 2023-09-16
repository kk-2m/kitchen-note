<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    // 多対1のリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ingredient_recipe()
    {
        return $this->belongsTo(Ingredient::class);
    }
    public function units()
    {
        return $this->belongsTo(Unit::class);
    }
}
