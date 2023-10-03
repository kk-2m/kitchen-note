<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientMenuPivot extends Pivot
{
    use HasFactory;
    
    public function menu()
    {
        return $this->belongsTo(Menu::class);
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
