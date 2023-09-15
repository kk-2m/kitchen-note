<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient_category extends Model
{
    use HasFactory;
    
    // 1対多のリレーション
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
