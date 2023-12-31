<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class Ingredient extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;
    
    protected $fillable = [
        'name',
        'ingredient_category_id',
    ];
    
    // 多対1のリレーション
    public function ingredient_category()
    {
        return $this->belongsTo(IngredientCategory::class);
    }
    public function units()
    {
        return $this->belongsTo(Unit::class);
    }
    
    // 1対多のリレーション
    public function shopping_lists()
    {
        return $this->hasMany(ShoppingList::class);
    }
    
    // 多対多のリレーション
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipe', 'ingredient_id', 'recipe_id')
                    ->withPivot('quantity', 'unit_id');
    }
    public function menus()
    {
        return $this->belongsToMany(Menu::class)
                    ->withPivot('quantity', 'unit_id');
    }
    
}
