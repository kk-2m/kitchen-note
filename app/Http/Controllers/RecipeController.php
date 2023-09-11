<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Procedure;

class RecipeController extends Controller
{
    public function index(Recipe $recipe)
    {
        // Recipeモデルで定義したgetByLimitを使用
        return view('recipes.recipe_index')->with(['recipes' => $recipe->getPaginateByLimit()]);
    }
    public function show(Recipe $recipe)
    {
        return view('recipes.recipe_show')->with(['recipe' => $recipe, 'procedures' => $recipe->procedures()->get()]);
    }
    public function create(Recipe $recipe)
    {
        return view('posts.create');
    }
}
