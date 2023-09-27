<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    public function getPaginateByLimit(int $limit_count = 1)
    {
        // paginate関数でget()を実行しているので、書く必要がない
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count); // ->get();
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
    public function units()
    {
        return $this->belongsTo(Unit::class);
    }
}
