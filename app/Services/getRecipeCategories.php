<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class getRecipeCategories
{
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
        
        echo $rakuten_recipe_categories;
    }
}