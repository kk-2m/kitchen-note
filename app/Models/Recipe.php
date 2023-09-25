<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    
    // 1度のページに表示する件数を制限
    public function getPaginateByLimit(int $limit_count = 2)
    {
        // paginate関数でget()を実行しているので、書く必要がない
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count); // ->get();
    }
    
    protected $fillable = [
        'user_id',
        'title',
        'number',
        'cooking_time',
        'cooking_time_unit',
        'image',
    ];
    
    // 多対1のリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function units()
    {
        return $this->belongsTo(Unit::class);
    }
    
    // 1対多のリレーション
    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    
    // 多対多のリレーション
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->using(IngredientRecipePivot::class)->withPivot('id', 'quantity', 'unit_id');
    }
}
