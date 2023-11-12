<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\RakutenRecipeCategory;
use App\Models\RakutenRecipe;
use App\Models\RakutenIngredient;

class RakutenRecipeController extends Controller
{
    public function getRanking(){
        $apiKey = config('services.rakuten_recipe.token');
        
        // GET通信するURL
        $url = "https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426?applicationId={$apiKey}";
        
        // クライアントインスタンス生成
        $client = new \GuzzleHttp\Client();
        // リクエスト送信と返却データの取得
        $response = $client->request('GET', $url);
        
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $contents = json_decode($response->getBody(), true);
        $api_rakutenrecipes = $contents['result'];
        
        // $serviceにRakutenRecipeServiceクラスをインスタンス化
        $service = app()->make('RakutenRecipeService');
        
        
        for ($i=0; $i<count($api_rakutenrecipes); $i++)
        {
            $input_ringredientrecipe = [];
            $quantities = $service->getQuantity($api_rakutenrecipes[$i]['recipeUrl']);
            foreach ($quantities as $quantity) {
                // 同じ名前のものがあったらfirstでDBからとる
                $rakuten_ingredient = RakutenIngredient::firstOrCreate([
                        'name' => $quantity['name']
                    ]);
                $input_ringredientrecipe[] = array(
                        "rakuten_recipe_id" => $i+1,
                        "rakuten_ingredient_id" => $rakuten_ingredient->id,
                        "serving" => $quantity["serving"],
                    );
            }
            
            // レシピの想定人数を取得
            $number = $service->getNumber($api_rakutenrecipes[$i]['recipeUrl']);
            
            // レシピの調理手順を取得
            // $procedure = $service->getProcedure($rakuten_recipes[$i]['recipeUrl']);
            // $rakuten_recipes[$i] += array("recipeProcedure" => $procedure);
            $input_rrecipe = [];
            // レシピの材料を取得
            $input_rrecipe = array(
                    "title" => $api_rakutenrecipes["{$i}"]["recipeTitle"],
                    "number" => $number,
                    "cooking_time" => $api_rakutenrecipes["{$i}"]["recipeIndication"],
                    "image" => $api_rakutenrecipes["{$i}"]["foodImageUrl"],
                    "url" => $api_rakutenrecipes["{$i}"]["recipeUrl"],
                );
            // print_r($input_rrecipe);
            $rakutenrecipe = RakutenRecipe::firstOrNew(['id' => $i+1]);
            $rakutenrecipe->fill($input_rrecipe)->save();
            $rakutenrecipe->rakuten_ingredients()->sync($input_ringredientrecipe);
        }
        // print_r($input_ringredientrecipe);
    }
    
    public function getCategories()
    {
        $apiKey = config('services.rakuten_recipe.token');
        
        // GET通信するURL
        $url = "https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426?format=json&applicationId={$apiKey}";
        
        // Guzzleクライアントのインスタンスを作成
        $client = new \GuzzleHttp\Client();
        
        // Guzzleを使用してHTMLを取得
        $response = $client->request('GET', $url);
        
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $contents = json_decode($response->getBody(), true);
        $rakuten_recipe_categories = $contents['result'];
        
        // カテゴリ一覧の「料理から探す」カテゴリのみ取得
        for ($i=1; $i<12; $i++) {
            $recipe_categories[$i] = $rakuten_recipe_categories['large'][$i]['categoryId'];
        }
        $recipe_categories += array(12 => $rakuten_recipe_categories['large'][0]['categoryId']);
        // dd($recipe_categories);
        
        foreach ($rakuten_recipe_categories['medium'] as $medium_categories) {
            $store_model = new RakutenRecipeCategory();
            if (in_array($medium_categories['parentCategoryId'], $recipe_categories, true)) {
                $rakuten_recipe_category = [
                    'category_id' => array_search($medium_categories['parentCategoryId'], $recipe_categories),
                    'parent_id' => $medium_categories['parentCategoryId'],
                    'rakuten_category_id' => $medium_categories['categoryId'],
                    'category_name' => $medium_categories['categoryName'],
                    'category_url' => $medium_categories['categoryUrl'],
                ];
                $store_model->fill($rakuten_recipe_category)->save();
            }
        }
        
        return redirect('/recipes');
    }
    
    public function category(Category $category)
    {
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('rakuten-recipes.rakuten-recipe_category')->with([
            'rakuten_categories' => $category->get(),
        ]);
    }
    
    public function recipe_index(Category $category)
    {
        // dd($category->rakuten_recipe_categories()->get());
        $categories = $category->get();
        foreach($categories as $category) {
            dd($category->rakuten_recipe_categories()->get());
        }
        
        $count = 0;
        $j = 0;
        foreach ($category->get() as $category) {
            $apiKey = config('services.rakuten_recipe.token');
        
            // GET通信するURL
            $url = "https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426?applicationId={$apiKey}&categoryId={$category->parent_id}-{$category->category_id}";
            // dd($category);
            // クライアントインスタンス生成
            $client = new \GuzzleHttp\Client();
            // リクエスト送信と返却データの取得
            $response = $client->request('GET', $url);
            
            // API通信で取得したデータはjson形式なので
            // PHPファイルに対応した連想配列にデコード
            $contents = json_decode($response->getBody(), true);
            $rakuten_recipes = $contents['result'];  // 4件取得
            // dd($rakuten_recipes);
            
            // $serviceにRakutenRecipeServiceクラスをインスタンス化
            $service = app()->make('RakutenRecipeService');
            
            for ($i=$j; $i<count($rakuten_recipes); $i++)
            {
                // レシピの材料を取得
                $quantity = $service->getQuantity($rakuten_recipes[$i]['recipeUrl']);
                $rakuten_recipes[$i] += array("recipeMaterialQuantity" => $quantity);
                // レシピの想定人数を取得
                $number = $service->getNumber($rakuten_recipes[$i]['recipeUrl']);
                $rakuten_recipes[$i] += array("recipeNumber" => $number);
                // レシピの調理手順を取得
                $procedure = $service->getProcedure($rakuten_recipes[$i]['recipeUrl']);
                $rakuten_recipes[$i] += array("recipeProcedure" => $procedure);
                dd($rakuten_recipes);
            }
            $j = $i;
            
            sleep(3);
            $count += 1;
            if ($count === 5) break;
        }
        
        dd($rakuten_recipes);
        
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('rakuten-recipes.rakuten-recipe_index');
    }
}
