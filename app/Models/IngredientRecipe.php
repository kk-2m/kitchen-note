<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientRecipe extends Model
{
    use HasFactory;
    
    // 多対1のリレーション
    // public function units()
    // {
    //     return $this->belongsTo(Unit::class);
    // }
}
