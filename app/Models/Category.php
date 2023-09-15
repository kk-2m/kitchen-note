<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    // 多対多のリレーション
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
