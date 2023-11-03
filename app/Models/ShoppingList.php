<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoppingList extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'ingredient_id',
        'menu_id',
        'status',
        'quantity',
        'unit_id'
    ];
    
    public function saveShoppinglistByMenu(string $userId, string $ingredientId, string $menuId, string $quantity, string $unitId)
    {
        return $this->fill([
                                'user_id' => $userId,
                                'ingredient_id' => $ingredientId,
                                'menu_id' => $menuId,
                                'quantity' => $quantity,
                                'unit_id' => $unitId,
                            ])->save();
    }
    
    // 1対1のリレーション
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
    
    // 多対1のリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
