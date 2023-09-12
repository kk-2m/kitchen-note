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
    public function create()
    {
        return view('recipes.recipe_create');
    }
//     public function store(Request $request, Recipe $recipe, Procedure $procedure)
//     {
//         // viewでrecipeに格納された内容をinputに渡す
//         $input_recipe = $request['recipe'];
//         $input_procedure = $request['procedure'];
//         $recipe->fill($input)->save();
//         $recipeId = $recipe->id;
//         $procedure->fill($procedure)->save();
//         return redirect('/recipes/' . $recipe);
//     }
}
