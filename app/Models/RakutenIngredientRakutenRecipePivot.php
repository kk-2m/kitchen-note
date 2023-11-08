<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RakutenIngredientRakutenRecipePivot extends Pivot
{
    use HasFactory;
    
    public function rakuten_recipe()
    {
        return $this->belongsTo(RakutenRecipe::class);
    }
    public function rakuten_ingredient()
    {
        return $this->belongsTo(RakutenIngredient::class);
    }
}
