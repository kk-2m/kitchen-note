<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\ShoppingList;
use App\Models\Unit;


class ShoppingListController extends Controller
{
    public function shoppinglist_index(ShoppingList $slist)
    {
        $userId = Auth::id();
        
        // index bladeに取得したデータを渡す
        // Recipeモデルで定義したgetByLimitを使用
        return view('shoppinglists.shoppinglist_index')->with([
            'slists' => $slist
                        ->where('user_id', $userId)
                        ->get(),
        ]);
    }
    
    public function shoppinglist_updateStatus(Request $request)
    {
        $input_slist = $request['slist'];
        
        ShoppingList::where('id', $input_slist['id'])->update(['status' => $input_slist['status']]);
        
        return response()->json(['message' => 'Status update successfully']);
    }
}
