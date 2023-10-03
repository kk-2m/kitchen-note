<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\Unit;

class StockController extends Controller
{
    public function stock_index(Stock $stock)
    {
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('stocks.stock_index')->with([
            'stocks' => $stock->getPaginateByLimit(),
        ]);
    }
    
    public function stock_create(Stock $stock, IngredientCategory $ingredient_category, Unit $unit)
    {
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('stocks.stock_create')->with([
            'ingredient_categories' => $ingredient_category->get(),
            'units' => $unit->get()]);
    }
    
    public function stock_store(StockRequest $request, Stock $stock)
    {
        // viewでrecipeに格納された内容をinputに渡す
        $input_stock = $request['stock'];
        $input_ingredient = $request['ingredient'];
        
        $ingredient = Ingredient::firstOrCreate(
            ['name' => $input_ingredient["name"]],
            ['ingredient_category_id' => $input_ingredient["ingredient_category_id"]
        ]);
        
        $input_stock += array('user_id' => $request->user()->id, 'ingredient_id' => $ingredient->id);
        // dd($input_stock);
        $stock->fill($input_stock)->save();
        
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return redirect('/stocks/');
    }
    
    public function stock_edit(Stock $stock, IngredientCategory $ingredient_category, Unit $unit)
    {
        return view('stocks.stock_edit')->with([
            'stock' => $stock,
            'ingredient_categories' => $ingredient_category->get(),
            'units' => $unit->get()]);
    }
    
    public function stock_update(StockRequest $request, Stock $stock)
    {
        // viewでrecipeに格納された内容をinputに渡す
        $input_stock = $request['stock'];
        $input_ingredient = $request['ingredient'];
        
        $stock->ingredient->fill($input_ingredient)->save();
        
        $input_stock += array('user_id' => $request->user()->id, 'ingredient_id' => $stock->ingredient_id);
        // dd($input_stock);
        $stock->fill($input_stock)->save();
        
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return redirect('/stocks/');
    }
    
    public function stock_delete(Stock $stock)
    {
        $stock->delete();
        return redirect('/stocks');
    }
}
