<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientRecipePivot extends Pivot
{
    use HasFactory;
    
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
