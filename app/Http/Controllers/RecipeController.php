<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
use App\Models\RakutenRecipeCategory;
use App\Models\RakutenRecipe;

class RecipeController extends Controller
{
    public function dashboard(RakutenRecipe $rakuten_recipe)
    {
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('dashboard')->with(['rakuten_recipes' => $rakuten_recipe->get()]);
    }
    
    public function recipe_index(Recipe $recipe)
    {
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('recipes.recipe_index')->with(['recipes' => $recipe->getPaginateByLimit()]);
    }
    
    public function recipe_show(Recipe $recipe)
    {
        return view('recipes.recipe_show')->with(
            [
                'recipe' => $recipe,
                'procedures' => $recipe->procedures()->get()
            ]);
    }
    
    public function recipe_create(Recipe $recipe, Category $category, IngredientCategory $ingredient_category, Unit $unit)
    {
        return view('recipes.recipe_create')->with(
            [
                'recipes' => $recipe->get(),
                'categories' => $category->get(),
                'ingredient_categories' => $ingredient_category->get(),
                'units' => $unit->get()
            ]);
    }
    
    public function recipe_store(RecipeRequest $request, Recipe $recipe)
    {
        // dd($request['ingredient_recipe']);
        
        // viewでrecipeに格納された内容をinputに渡す
        $input_recipe = $request['recipe'];
        $input_procedures = $request['procedure'];
        $input_categories = $request['category'];
        $input_ingredients = $request['ingredient'];
        $input_ingredient_recipe = $request['ingredient_recipe'];
        
        $userId = $request->user()->id;
        
        // *recipesテーブルへの保存*
        // ログイン処理がログイン情報に基づいて、ユーザーIDを取得する処理に変える
        $input_recipe += array('user_id'=>$userId);
        if ($request->file('recipe.image')) {
            // アップロードされたファイル名を取得
            // $file_name = $request->file('recipe.image')->getClientOriginalName();
            $file = $request->file('recipe.image');
            if(!\Storage::disk('sftp')->exists($userId)) {
                \Storage::disk('sftp')->makeDirectory($userId);
            }
            // ファイルをSFTPサーバーの 'KitchenNote' ディレクトリに保存
            // Laravelはファイル名を自動的に生成
            $path = Storage::disk('sftp')->putFile($userId, $file);
            
            // 取得したファイル名で保存
            $input_recipe['image'] = $path;
        }
        $recipe->fill($input_recipe)->save();
        
        // *proceduresテーブルへの保存*
        // resipesテーブルにインサートされたときに付けれられるidを取得
        $recipeId = $recipe->id;
        // input_procedureに格納されている連想配列にrecipe_idを追加
        for ($i=1; $i<count($input_procedures)+1; $i++) {
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
        // array_filter(array)でNULL以外を取り出す
        // sync(array)で同期処理(requestのあったカテゴリのみチェック)
        $recipe->categories()->sync(array_filter($input_categories));
        
        // *ingredientsテーブルへの保存*
        for ($i=1; $i<count($input_ingredients)+1; $i++) {
            // nameによりDBからingredientを取得します
            // DBにない場合はname、ingredient_category_id属性を使用してingredientを作成します。
            $ingredient = Ingredient::firstOrCreate(
                ['name' => $input_ingredients["{$i}"]["name"]],
                ['ingredient_category_id' => $input_ingredients["{$i}"]["ingredient_category_id"]]
            );
            
            // *ingredient_recipeテーブルへの保存*
            // syncWithoutDetachingで完全な重複以外を許容
            $recipe->ingredients()
                ->syncWithoutDetaching([
                    $ingredient->id=>[
                        'quantity' => $input_ingredient_recipe["{$i}"]["quantity"],
                        'unit_id' => $input_ingredient_recipe["{$i}"]["unit_id"]]
                    ]);
        }
        
        return redirect('/recipes/' . $recipeId);
    }
    
    public function recipe_edit(Recipe $recipe, Category $category, IngredientCategory $ingredient_category, Unit $unit)
    {
        return view('recipes.recipe_edit')->with(
            [
                'recipe' => $recipe,
                'categories' => $category->get(),
                'ingredient_categories' => $ingredient_category->get(),
                'units' => $unit->get()
            ]);
    }
    
    public function recipe_update(RecipeRequest $request, Recipe $recipe)
    {
        // *recipesテーブルへの保存*
        // viewでrecipeに格納された内容をinputに渡す
        $input_recipe = $request['recipe'];
        $input_procedures = $request['procedure'];
        $input_categories = $request['category'];
        $input_ingredients = $request['ingredient'];
        $input_ingredient_recipe = $request['ingredient_recipe'];
        
        // dd($input_ingredients);
        $userId = $request->user()->id;
        
        // *recipesテーブルへの保存*
        // ログイン処理がログイン情報に基づいて、ユーザーIDを取得する処理に変える
        // requestの送信者のuser_idを$input_recipeに追加
        $input_recipe += array('user_id'=>$request->user()->id);
        if ($request->file('recipe.image')) {
            // アップロードされたファイル名を取得
            // $file_name = $request->file('recipe.image')->getClientOriginalName();
            // 元々登録されていた画像は削除
            if($recipe->image != null) Storage::disk('sftp')->delete($recipe->image);
            $file = $request->file('recipe.image');
            if(!\Storage::disk('sftp')->exists($userId)) {
                \Storage::disk('sftp')->makeDirectory($userId);
            }
            // ファイルをSFTPサーバーの 'KitchenNote' ディレクトリに保存
            // Laravelはファイル名を自動的に生成
            $path = Storage::disk('sftp')->putFile($userId, $file);
            
            // 取得したファイル名で保存
            $input_recipe['image'] = $path;
        }
        $recipe->fill($input_recipe)->save();
        
        // resipesテーブルにインサートされたときに付けれられるidを取得
        $recipeId = $recipe->id;
        
        // あるレシピが持っている調理手順のprocedure idを$procedureIdに配列として格納
        $procedureId = $recipe->procedures()->pluck('id');
        // あるレシピが持っている中間テーブルのidを$pibotIdに配列として格納
        $pivotId = $recipe->ingredients->pluck('pivot.id');
        
        // dd($recipe->procedures);
        // *proceduresテーブルへの保存*
        // input_procedureに格納されている連想配列にrecipe_idを追加
        // リクエストが既存のproceduresテーブルのレコードよりも多かった場合
        // 超過分のレコードを新しく保存
        if (count($recipe->procedures) <= count($input_procedures)) {
            for ($i=1; $i<count($input_procedures)+1; $i++) {
                // dd($recipeId);
                // $procedureをループ毎にインスタンス化しないと追加されない
                // https://yama-weblog.com/can-not-save-multiple-record-using-foreach-in-laravel8/
                if ($i <= count($recipe->procedures)) {
                    $procedure = Procedure::where('recipe_id', $recipeId)
                        // $procedureIdは0から始まる
                        ->where('id', $procedureId[$i-1])
                        ->first();    
                }
                else $procedure = new Procedure();
                    
                // keyを'body'に変更
                // saveをする前に$procedureの存在確認
                if ($procedure) {
                    $procedure->fill(
                        [
                            'body' => $input_procedures["{$i}"]['body'],
                            'recipe_id' => $recipeId,
                        ])->save();
                }
            }    
        }
        // リクエストが既存のproceduresテーブルのレコードよりも少なかった場合
        // （既存のレコード数）ー（リクエスト数）を削除する
        else {
            for ($i=1; $i<count($recipe->procedures)+1; $i++) {
                // dd($recipeId);
                // $procedureをループ毎にインスタンス化しないと追加されない
                // https://yama-weblog.com/can-not-save-multiple-record-using-foreach-in-laravel8/
                
                $procedure = Procedure::where('recipe_id', $recipeId)
                                // $procedureIdは0から始まる
                                ->where('id', $procedureId[$i-1])
                                ->first();
                // dd($i, count($input_procedures), count($recipe->procedures));
                if ($i <= count($input_procedures) and $procedure) {
                    $procedure->fill(
                        [
                            'body' => $input_procedures["{$i}"]['body'],
                            'recipe_id' => $recipeId,
                        ])->save();
                }
                // リクエストより多いレコードは削除
                else $procedure->delete();
            }
        }
        
        
        // *categorie_recipeテーブルへの保存*
        // array_filter(array)でNULL以外を取り出す
        // sync(array)で同期処理(requestのあったカテゴリのみチェック)
        $recipe->categories()->sync(array_filter($input_categories));
        
        // *ingredientsテーブルへの保存*
        $i = 1;
        // foreach ($recipe->ingredients as $ingredient) {
        //     // nameによりDBからingredientを取得します
        //     // DBにない場合はname、ingredient_category_id属性を使用してingredientを作成します。
        //     $ingredient->fill($input_ingredients["{$i}"])->save();
            
        //     // *ingredient_recipeテーブルへの保存*
        //     // 既存の中間レコードを特定
        //     // あるレシピが持つ中間テーブルのidを用いてレコードを一意に定める
        //     // クエリがレコードの数より多ければ新規作成*1
        //     $j = $i-1;
        //     $existingPivotRecord = $recipe->ingredients()
        //         ->wherePivot('id', $pivotId["{$j}"])
        //         ->get();
            
        //     // DBの中間テーブルにアクセスし、requestのingredient idと同じか判定
        //     // 同じじゃなければDBのingredient idをrequestのingredient idに変更*2
        //     if ($existingPivotRecord[0]->pivot->ingredient_id !==  $ingredient->id){
        //         $existingPivotRecord[0]->pivot->ingredient_id = $ingredient->id;
        //         $existingPivotRecord[0]->pivot->save();
        //     }

        //     // *1 中間レコードが見つかれば更新、見つからなければ新規作成
        //     if ($existingPivotRecord) {
        //         // updateExistingPivotを用いて更新
        //         // *2でrequestのingredient idに変更しているため、updateExistingPivotを使って更新可能(既存のレコード)
        //         $recipe->ingredients()->updateExistingPivot($ingredient->id, [
        //             'quantity' => $input_ingredient_recipe["{$i}"]["quantity"],
        //             'unit_id' => $input_ingredient_recipe["{$i}"]["unit_id"]
        //         ]);
        //     }else {
        //         // requestが既存のレコードより多ければ新規作成
        //         $recipe->ingredients()
        //             ->syncWithoutDetaching([
        //                 $ingredient->id=>[
        //                 'quantity' => $input_ingredient_recipe["{$i}"]["quantity"],
        //                 'unit_id' => $input_ingredient_recipe["{$i}"]["unit_id"]
        //             ]]);
        //     }
        //     $i += 1;
        // }
        
        for ($i=1; $i<count($input_ingredients)+1; $i++) {
            // nameによりDBからingredientを取得します
            // DBにない場合はname、ingredient_category_id属性を使用してingredientを作成します。
            $ingredient = Ingredient::firstOrCreate(
                ['name' => $input_ingredients["{$i}"]["name"]],
                ['ingredient_category_id' => $input_ingredients["{$i}"]["ingredient_category_id"]]
            );
            // 中間テーブルのリクエストにrecipe_idと、ingredient_idを追加
            $input_ingredient_recipe["{$i}"] += array('recipe_id'=>$recipeId, 'ingredient_id'=>$ingredient->id);
        }
        // *ingredient_recipeテーブルへの保存*
        $recipe->ingredients()->sync($input_ingredient_recipe);
        
        return redirect('/recipes/' . $recipeId);
    }
    
    public function recipe_delete(Recipe $recipe)
    {
        // 元々登録されていた画像は削除
        if($recipe->image != null) Storage::disk('sftp')->delete($recipe->image);
        $recipe->delete();
        return redirect('/recipes');
    }
}
