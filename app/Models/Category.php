<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
    ];
    
    // 多対多のリレーション
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
    
    public function rakuten_recipe_categories()
    {
        return $this->hasMany(RakutenRecipeCategory::class);
    }
}
