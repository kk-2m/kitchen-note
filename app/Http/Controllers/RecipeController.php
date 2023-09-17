<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Procedure;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\IngredientCategory;
use App\Models\Menu;
use App\Models\ShoppingList;
use App\Models\Stock;
use App\Models\User;
use App\Models\Unit;
use App\Models\UnitConversion;


class RecipeController extends Controller
{
    public function index(Recipe $recipe)
    {
        // $recipe = Recipe::find(2)->ingredients;
        // dd($recipe);
        // Recipeモデルで定義したgetByLimitを使用
        return view('recipes.recipe_index')->with(['recipes' => $recipe->getPaginateByLimit()]);
    }
    
    public function show(Recipe $recipe)
    {
        return view('recipes.recipe_show')->with(['recipe' => $recipe, 'procedures' => $recipe->procedures()->get()]);
    }
    
    public function create(Recipe $recipe, Category $category, IngredientCategory $ingredient_category)
    {
        return view('recipes.recipe_create')->with(['recipes' => $recipe->get(), 'categories' => $category->get(), 'ingredient_categories' => $ingredient_category->get()]);
    }
    
    public function store(Request $request, Recipe $recipe)
    {
        // アップロードされたファイル名を取得
        $file_name = $request->file('recipe.image')->getClientOriginalName();
        // 取得したファイル名で保存
        $request->file('recipe.image')->storeAs('public/dish_image/', $file_name);
        
        // *recipesテーブルへの保存*
        // viewでrecipeに格納された内容をinputに渡す
        // dd($request['recipes']);
        $input_recipe = $request['recipe'];
        $input_procedures = $request['procedure'];
        // ログイン処理がログイン情報に基づいて、ユーザーIDを取得する処理に変える
        // それまでは便宜上user_idを1とする
        $input_recipe += array('user_id'=>1);
        $input_recipe += array('cooking_time_unit'=>2);
        $input_recipe['image'] = 'storage/dish_image/' . $file_name;
        // dd($input_recipe);
        $recipe->fill($input_recipe)->save();
        
        // *proceduresテーブルへの保存*
        // resipesテーブルにインサートされたときに付けれられるidを取得
        $recipeId = $recipe->id;
        // input_procedureに格納されている連想配列にrecipe_idを追加
        foreach ($input_procedures as $key => $value) {
            // $procedureをループ毎にインスタンス化しないと追加されない
            // https://yama-weblog.com/can-not-save-multiple-record-using-foreach-in-laravel8/
            $procedure = new Procedure();
            // keyを'body'に変更
            $procedure->fill(['body'=>$value, 'recipe_id'=>$recipeId])->save();
        }
        
        // categories
        
        return redirect('/recipes/' . $recipeId);
    }
    
    public function edit(Recipe $recipe, Category $category)
    {
        return view('recipes.recipe_edit')->with(['recipe' => $recipe, 'procedures' => $recipe->procedures()->get(), 'categories' => $category->get()]);
    }
    
    public function update(RecipeRequest $request, Recipe $recipe)
    {
        $input_recipe = $request['recipe'];
        $recipe->fill($input_recipe)->save();
    
        return redirect('/recipes/' . $recipe->id);
    }
}
