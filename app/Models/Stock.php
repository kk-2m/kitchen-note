<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function getPaginateByLimit(int $limit_count = 1)
    {
        // paginate関数でget()を実行しているので、書く必要がない
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count); // ->get();
    }
    
    protected $fillable = [
        'user_id',
        'ingredient_id',
        'expiration_at',
        'quantity',
        'unit_id',
    ];
    
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
