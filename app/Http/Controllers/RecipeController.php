<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RecipeRequest;
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
    
    public function create(Recipe $recipe, Category $category, IngredientCategory $ingredient_category, Unit $unit)
    {
        return view('recipes.recipe_create')->with(['recipes' => $recipe->get(), 'categories' => $category->get(), 'ingredient_categories' => $ingredient_category->get(), 'units' => $unit->get()]);
    }
    
    public function store(RecipeRequest $request, Recipe $recipe)
    {
        // dd($request['category']);
        // dd($request['procedure']["1"]);
        
        // アップロードされたファイル名を取得
        if ($request->file('recipe.image')){
            $file_name = $request->file('recipe.image')->getClientOriginalName();
            // 取得したファイル名で保存
            $request->file('recipe.image')->storeAs('public/dish_image/', $file_name);
        }
        
        
        // *recipesテーブルへの保存*
        // viewでrecipeに格納された内容をinputに渡す
        $input_recipe = $request['recipe'];
        $input_procedures = $request['procedure'];
        $input_categories = $request['category'];
        $input_ingredients = $request['ingredient'];
        $input_ingredient_recipe = $request['ingredient_recipe'];
        
        // *recipesテーブルへの保存*
        // ログイン処理がログイン情報に基づいて、ユーザーIDを取得する処理に変える
        // それまでは便宜上user_idを1とする
        $input_recipe += array('user_id'=>1);
        if ($request->file('recipe.image')) $input_recipe['image'] = 'storage/dish_image/' . $file_name;
        $recipe->fill($input_recipe)->save();
        
        // *proceduresテーブルへの保存*
        // resipesテーブルにインサートされたときに付けれられるidを取得
        $recipeId = $recipe->id;
        // input_procedureに格納されている連想配列にrecipe_idを追加
        for ($i=1; $i<count($input_procedures)+1; $i++) {
            // dd($recipeId);
            // $procedureをループ毎にインスタンス化しないと追加されない
            // https://yama-weblog.com/can-not-save-multiple-record-using-foreach-in-laravel8/
            $procedure = new Procedure();
            // keyを'body'に変更
            $procedure->fill(
                [
                    'body' => $input_procedures["{$i}"]['body'],
                    'recipe_id' => $recipeId,
                ])->save();
        }
        
        // *categorie_recipeテーブルへの保存*
        foreach ($input_categories as $key => $value) {
            // syncWithoutDetachingで完全な重複以外を許容
            // https://biz.addisteria.com/syncwithoutdetaching/
            $recipe->categories()->syncWithoutDetaching($value);
        }
        
        // *ingredientsテーブルへの保存*
        for ($i=1; $i<count($input_ingredients)+1; $i++) {
            $ingredient = Ingredient::firstOrCreate(
                ['name' => $input_ingredients["{$i}"]["name"]],
                ['ingredient_category_id' => $input_ingredients["{$i}"]["ingredient_category_id"]]
            );
            
            // syncWithoutDetachingで完全な重複以外を許容
            $recipe->ingredients()
                ->syncWithoutDetaching([
                    $ingredient->id=>[
                        'quantity' => $input_ingredient_recipe["{$i}"]["quantity"],
                        'unit_id' => $input_ingredient_recipe["{$i}"]["unit_id"]]
                    ]);
        }
        
        // // *ingredient_recipeテーブルへの保存*
        // for ($i=1; $i<count($input_ingredients)+1; $i++) {
        //     // syncWithoutDetachingで完全な重複以外を許容
        //     $recipe->ingredients()->syncWithoutDetaching($value);
        // }
        
        return redirect('/recipes/' . $recipeId);
    }
    
    public function edit(Recipe $recipe, Category $category)
    {
        return view('recipes.recipe_edit')->with(['recipe' => $recipe, 'procedures' => $recipe->procedures()->get(), 'categories' => $category->get()]);
    }
    
    public function update(RecipeRequest $request, Recipe $recipe)
    {
        // アップロードされたファイル名を取得
        // $file_name = $request->file('recipe.image')->getClientOriginalName();
        // // 取得したファイル名で保存
        // $request->file('recipe.image')->storeAs('public/dish_image/', $file_name);
        
        // *recipesテーブルへの保存*
        // viewでrecipeに格納された内容をinputに渡す
        // dd($request['recipes']);
        $input_recipe = $request['recipe'];
        $input_procedures = $request['procedure'];
        $input_categories = $request['category'];
        
        // dd($request["procedure"]);
        
        // ログイン処理がログイン情報に基づいて、ユーザーIDを取得する処理に変える
        // それまでは便宜上user_idを1とする
        $input_recipe += array('user_id'=>1);
        // $input_recipe += array('cooking_time_unit'=>2);
        $input_recipe['image'] = 'storage/dish_image/' . "tyometyome";
        // dd($input_recipe);
        $recipe->fill($input_recipe)->save();
        
        // *proceduresテーブルへの保存*
        // resipesテーブルにインサートされたときに付けれられるidを取得
        $recipeId = $recipe->id;
        // dd($input_procedures);
        // input_procedureに格納されている連想配列にrecipe_idを追加
        foreach ($input_procedures as $key => $value) {
            // $procedureをループ毎にインスタンス化しないと追加されない
            // https://yama-weblog.com/can-not-save-multiple-record-using-foreach-in-laravel8/
            $procedure = new Procedure();
            // keyを'body'に変更
            $procedure->fill(['body'=>$value, 'recipe_id'=>$recipeId])->save();
        }
        
        // *categorie_recipeテーブルへの保存*
        foreach ($input_categories as $key => $value) {
            // syncWithoutDetachingで完全な重複以外を許容
            $recipe->categories()->syncWithoutDetaching($value);
        }
        return redirect('/recipes/' . $recipeId);
    }
}
