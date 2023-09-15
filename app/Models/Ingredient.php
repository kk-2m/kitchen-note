<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    
    // 多対1のリレーション
    public function ingredient_category()
    {
        return $this->belongsTo(Ingredient_category::class);
    }
    
    // 1対多のリレーション
    public function shopping_lists()
    {
        return $this->hasMany(Shopping_list::class);
    }
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    
    // 多対多のリレーション
    public function recipes()
    {
        return $this->belongsToMany(recipe::class);
    }
    
}
