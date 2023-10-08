<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientRecipe extends Model
{
    use HasFactory;
    
    protected $table = 'ingredient_recipe';
    protected $fillable = [
        'ingredient_id',
        'recipe_id',
        'quantity',
        'unit_id',
    ];
    
    // 多対1のリレーション
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
