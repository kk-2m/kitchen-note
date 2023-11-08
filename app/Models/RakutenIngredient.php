<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class RakutenIngredient extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;
    
    protected $fillable = [
        'name'
    ];
    
    // 多対多のリレーション
    public function rakuten_recipes()
    {
        return $this->belongsToMany(RakutenRecipe::class)
                    ->withPivot('id', 'serving');
    }
}
