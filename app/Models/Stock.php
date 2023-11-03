<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        $userId = Auth::id();
        // paginate関数でget()を実行しているので、書く必要がない
        return $this->where('user_id', $userId)->orderBy('updated_at', 'DESC')->paginate($limit_count); // ->get();
    }
    
    protected $fillable = [
        'user_id',
        'ingredient_id',
        'shopping_list_id',
        'expiration_at',
        'quantity',
        'unit_id',
    ];
    
    // 1対1のリレーション
    public function shopping_list()
    {
        return $this->belongsTo(ShoppingList::class);
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
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
