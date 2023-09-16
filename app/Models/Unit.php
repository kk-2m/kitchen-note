<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    
    // 1対多のリレーション
    public function shopping_lists()
    {
        return $this->hasMany(ShoppingList::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function unit_conversions()
    {
        return $this->hasMany(UnitConversion::class);
    }
        public function ingredient_recipe()
    {
        return $this->hasMany(IngredientRecipe::class);
    }
    
    // 多対多のリレーション
    // public function recipes()
    // {
    //     return $this->belongsToMany(Recipe::class, 'ingredient_recipe', 'unit_id', 'recipe_id')
    //                 ->withPivot('quantity');
    // }
    // public function ingredients()
    // {
    //     return $this->belongsToMany(Ingredient::class);
    // }
}
