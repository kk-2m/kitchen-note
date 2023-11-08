<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RakutenRecipe extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'number',
        'cooking_time',
        'image',
        'url'
    ];
    
    // 多対多のリレーション
    public function rakuten_ingredients()
    {
        return $this->belongsToMany(RakutenIngredient::class)
            ->using(RakutenIngredientRakutenRecipePivot::class)->withPivot('id', 'serving');
    }
}
