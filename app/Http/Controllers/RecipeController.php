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
    public function store(Request $request, Recipe $recipe)
    {
        // viewでrecipeに格納された内容をinputに渡す
        $input_recipe = $request['recipes'];
        $input_procedures = $request['procedures'];
        // ログイン処理がログイン情報に基づいて、ユーザーIDを取得する処理に変える
        // それまでは便宜上user_idを1とする
        $input_recipe += array('user_id'=>1);
        $recipe->fill($input_recipe)->save();
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
        return redirect('/recipes/' . $recipeId);
    }
}
