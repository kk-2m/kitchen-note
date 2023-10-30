<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\ShoppingList;
use App\Models\Unit;


class ShoppingListController extends Controller
{
    public function shoppinglist_index(ShoppingList $slist, Ingredient $ingredient, Unit $unit)
    {
        $userId = Auth::id();
        $ingredient_name = $ingredient->select(['name'])->get();
        
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('shoppinglists.shoppinglist_index')->with([
            'slists' => $slist
                        ->where('user_id', $userId)
                        ->get(),
            'ingredients' => $ingredient_name,
            'units' => $unit->get(),
        ]);
    }
    
    public function shoppinglist_store(Request $request, ShoppingList $slist)
    {
        $input_ingredient = $request['ingredient'];
        $input_slist = $request['slist'];
        
        $ingredient = Ingredient::where('name', $input_ingredient['name'])
                    ->first();
                    
        // dd($ingredient);
        
        $input_slist += array('user_id' => $request->user()->id, 'ingredient_id' => $ingredient->id);
        // dd($input_slist);
        $slist->fill($input_slist)->save();
        
        return redirect('/shoppinglists/');
    }
    
    public function shoppinglist_search(Request $request)
    {
        $term = $request->input('term');
        $ingredients = Ingredient::where('name', 'like', '%' . $term . '%')
                    ->orWhere('name', 'like', '%' . $term . '% COLLATE utf8_unicode_ci')
                    ->get();
        
        return response()->json($ingredients);
    }
    
    public function shoppinglist_updateStatus(Request $request, ShoppingList $slist)
    {
        $input_slist = $request['slist'];
        
        $slist->fill($input_slist)->save();
        
        // ShoppingList::where('id', $input_slist['id'])->update(['status' => $input_slist['status']]);
        
        // $stock = Stock::where('user_id' => $slist->user_id)
        //                     ->where('ingredient_id' => $slist->ingredient_id)
        //                     ->where('unit_id' => $slist->unit_id)
        //                     ->orderBy('expiration_at', 'ASC')
        //                     ->first();
        
        if ($input_slist['status'] === '1') {
            $stockdata = array(
                    'user_id' => $slist->user_id,
                    'ingredient_id' => $slist->ingredient_id,
                    'shopping_list_id' => $slist->id,
                    'expired_at' => NULL,
                    'quantity' => $slist->quantity,
                    'unit_id' => $slist->unit_id,
                    );
            // 論理削除されているものがあれば再利用
            // データの増大を防ぐ
            $stock = Stock::onlyTrashed()->where('shopping_list_id', $slist->id)->first();
            if ($stock) {
                $stock->restore();
                $stock->fill($stockdata)->save();
            }
            else {
                $stock = new Stock();
                $stock->fill($stockdata)->save();
            }
            
        }
        else {
            $stock = Stock::where('user_id', $slist->user_id)->where('shopping_list_id', $slist->id)->where('quantity', '>=', $slist->quantity);
            if ($stock) {
                $stock->delete();
            }
        }
        
        
        // return redirect(route('stock_create'))->with([
        //         'stock' => $stock,
        //         'ingredient_categories' => $ingredient_category->get(),
        //         'units' => $unit->get()]);
        //     ]);
        // return response()->json(['message' => $slist]);
        return response()->json(['message' => $slist->id]);
    }
    
    public function shoppinglist_edit(ShoppingList $slist, Ingredient $ingredient, Unit $unit)
    {
        return view('shoppinglists.shoppinglist_edit')->with([
                'slist' => $slist,
                'ingredients' => $ingredient->get(),
                'units' => $unit->get(),
            ]);
    }
    
    public function shoppinglist_update(Request $request, ShoppingList $slist)
    {
        $input_slist = $request['slist'];
        // dd($input_slist);
        
        $slist->fill($input_slist)->save();
        
        return redirect('/shoppinglists/');
    }
    
    public function shoppinglist_delete(ShoppingList $slist)
    {
        $slist->delete();
        return redirect('/shoppinglists');
    }
}
