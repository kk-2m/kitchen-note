<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'recipe_id',
        'user_id',
        'number',
        'date',
    ];
    
    // 1対多のリレーション
    public function shopping_lists()
    {
        return $this->hasMany(ShoppingList::class);
    }
    
    // 多対1のリレーション
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // 多対多のリレーション
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->using(IngredientMenuPivot::class)->withPivot('id', 'quantity', 'unit_id');
    }
    
    
}
