<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Ingredient;

class StockController extends Controller
{
    public function stock_index(Stock $stock)
    {
        // $stock = $stock->get();
        // // dd($stock);
        // foreach ($stock as $stock) {
        //     dd($stock->ingredient()->get());
        // }
        
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('stocks.stock_index')->with([
            'stocks' => $stock->getPaginateByLimit(),
        ]);
    }
}
