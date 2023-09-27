<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\RakutenRecipeCategory;

class RakutenRecipeController extends Controller
{
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
        // $category->get();
        // $categories = $category->get();
        // foreach($categories as $category) {
        //     dd($category->rakuten_recipe_categories()->get());
        // }
        
        // $count = 0;
        // $j = 0;
        // foreach ($category->get() as $category) {
        //     $apiKey = config('services.rakuten_recipe.token');
        
        //     // GET通信するURL
        //     $url = "https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426?applicationId={$apiKey}&categoryId={$category->parent_id}-{$category->category_id}";
        //     // dd($category);
        //     // クライアントインスタンス生成
        //     $client = new \GuzzleHttp\Client();
        //     // リクエスト送信と返却データの取得
        //     $response = $client->request('GET', $url);
            
        //     // API通信で取得したデータはjson形式なので
        //     // PHPファイルに対応した連想配列にデコード
        //     $contents = json_decode($response->getBody(), true);
        //     $rakuten_recipes = $contents['result'];  // 4件取得
        //     // dd($rakuten_recipes);
            
        //     // $serviceにRakutenRecipeServiceクラスをインスタンス化
        //     $service = app()->make('RakutenRecipeService');
            
        //     for ($i=$j; $i<count($rakuten_recipes); $i++)
        //     {
        //         // レシピの材料を取得
        //         $quantity = $service->getQuantity($rakuten_recipes[$i]['recipeUrl']);
        //         $rakuten_recipes[$i] += array("recipeMaterialQuantity" => $quantity);
        //         // レシピの想定人数を取得
        //         $number = $service->getNumber($rakuten_recipes[$i]['recipeUrl']);
        //         $rakuten_recipes[$i] += array("recipeNumber" => $number);
        //         // レシピの調理手順を取得
        //         $procedure = $service->getProcedure($rakuten_recipes[$i]['recipeUrl']);
        //         $rakuten_recipes[$i] += array("recipeProcedure" => $procedure);
        //         dd($rakuten_recipes);
        //     }
        //     $j = $i;
            
        //     sleep(3);
        //     $count += 1;
        //     if ($count === 5) break;
        // }
        
        // dd($rakuten_recipes);
        
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('rakuten-recipes.rakuten-recipe_index');
    }
}
