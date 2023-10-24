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
    
    public function shoppinglist_updateStatus(Request $request)
    {
        $input_slist = $request['slist'];
        
        ShoppingList::where('id', $input_slist['id'])->update(['status' => $input_slist['status']]);
        
        return response()->json(['message' => 'Status update successfully']);
    }
    
    public function shoppinglist_delete(ShoppingList $slist)
    {
        $slist->delete();
        return redirect('/shoppinglists');
    }
}
