<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    
    // 1度のページに表示する件数を制限
    public function getPaginateByLimit(int $limit_count = 1)
    {
        // paginate関数でget()を実行しているので、書く必要がない
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count); // ->get();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }
    
    protected $fillable = [
        'user_id',
        'title',
        'cooking_time',
        'cooking_time_unit',
        'image',
    ];
}
