<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RakutenRecipeCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    public function getPaginateByLimit(int $limit_count = 10)
    {
        // paginate関数でget()を実行しているので、書く必要がない
        return $this->orderBy('parent_category_id', 'DESC')->paginate($limit_count); // ->get();
    }
    
    protected $fillable = [
        'id',
        'rakuten_category_id',
        'parent_id',
        'category_id',
        'category_name',
        'category_url',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
