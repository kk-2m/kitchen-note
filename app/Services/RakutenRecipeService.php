<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class RakutenRecipeService
{
    public function getQuantity($url)
    {
        // Guzzleクライアントのインスタンスを作成
        $client = new \GuzzleHttp\Client();
        
        // Guzzleを使用してHTMLを取得
        $response = $client->request('GET', $url);
        
        // HTMLをCrawlerに読み込む
        $crawler = new Crawler($response->getBody()->getContents());
        
        // 材料の数量を抽出
        $materialElements = $crawler->filter("ul.recipe_material__list li.recipe_material__item");
        
        // 各材料の数量を取得
        $materialElements->each(function ($element) use (&$materials) {
            $name = $element->filter('span.recipe_material__item_name')->text();
            $serving = $element->filter('span.recipe_material__item_serving')->text();
            
            $materials[] = [
                'name' => $name,
                'serving' => $serving,
            ];
        });
        
        return $materials;
    }
    
    public function getNumber($url)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $crawler = new Crawler($response->getBody()->getContents());
        
        // 人数を抽出
        $recipeNumber = $crawler->filter("h2.contents_title.contents_title_mb")->text();
        
        // "（" と "人分" の間のテキストを抽出
        if (preg_match('/（(.*?)人分）/', $recipeNumber, $matches)) {
            $number = $matches[1];
        }
        
        return (int)$number;
    }
    
    public function getProcedure($url)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $crawler = new Crawler($response->getBody()->getContents());
        
        // 手順情報の抽出
        $recipeProcedures = $crawler->filter("ol.recipe_howto__list li.recipe_howto__item");
        
        $recipeProcedures->each(function ($element) use (&$procedures) {
            $procedures[] = $element->filter('span.recipe_howto__text')->text();
        });
        return $procedures;
    }
    
    // public function getCategory($url)
    // {
    //     $client = new \GuzzleHttp\Client();
    //     $response = $client->request('GET', $url);
    //     $crawler = new Crawler($response->getBody()->getContents());
        
    //     $recipeCategories = $crawler->filter("ul.breadcrumb__list li.breadcrumb__item");
        
    //     $recipeCategories->each(function ($element) use (&$categories) {
    //         $catgo
    //     });
    // }
}