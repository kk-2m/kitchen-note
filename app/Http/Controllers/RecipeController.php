<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Procedure;

class RecipeController extends Controller
{
    public function index(Recipe $recipe)
    {
        return $recipe->get();
    }
    public function show(Procedure $recipe)
    {
        return $recipe->get();
    }
}
