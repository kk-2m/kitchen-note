<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MenuRequest;
use Carbon\Carbon;
use App\Models\Recipe;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\ShoppingList;

class MenuController extends Controller
{
    public function menu_index(Menu $menu)
    {
        $userId = Auth::id();
        
        $today = Carbon::today();
        $weekLater = $today->copy()->addWeek();
        
        $menu->get();
        
        return view('menus.menu_index')->with(
            [
                'menus' => $menu
                            ->where('user_id', $userId)
                            ->where('date', '>=', $today)
                            ->where('date', '<', $weekLater)
                            ->orderBy('date', 'ASC')
                            ->get(),
            ]);
    }
    
    public function menu_create(Request $request, Recipe $recipe)
    {
        $recipeId = $request->input('recipe_id');
        
        return view('menus.menu_create')->with(
            [
                'recipes' => $recipe->get(),
                'recipeId' => $recipeId,
            ]);
    }
    
    public function menu_store(MenuRequest $request, Menu $menu)
    {
        $input_menu = $request['menu'];
        $userId = $request->user()->id;
        $input_menu += array('user_id' => $userId);
        // dd($input_menu);
        
        $menu->fill($input_menu)->save();
        
        // $menuId = $menu->id;
        
        $recipe = $menu->recipe;
        $ingredients = $recipe->ingredients;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity / $recipe->number * $menu->number;
            $unitId = $ingredient->pivot->unit_id;
            
            $menu->ingredients()->syncWithoutDetaching(
                    [
                        $ingredient->pivot->ingredient_id=>[
                                'quantity' => $quantity,
                                'unit_id' => $unitId,
                            ]
                    ]
            );
            // $slist = new ShoppingList();
            
            // $stockSum = Stock::where('user_id', $userId)
            //             ->where('ingredient_id', $ingredient->id)
            //             ->where('unit_id', $unitId)
            //             ->sum('quantity');
            
            // $existingMenuSum = DB::table('ingredient_menu')
            //                     ->where('ingredient_id', $ingredient->id)
            //                     ->where('unit_id', $unitId)
            //                     ->where('menu_id', '!=', $menuId)
            //                     // 親テーブルが論理削除されていないものを取得
            //                     ->whereIn('menu_id', function ($query) use ($userId) {
            //                         $query->select('id')
            //                             ->from('menus')
            //                             ->where('user_id', $userId)
            //                             ->whereNull('deleted_at');
            //                     })
            //                     ->sum('quantity');
            // // dd($existingMenuSum, $stockSum);
            
            // // 同じ食材を使っている献立があるとき
            // if ($existingMenuSum > 0) {
            //     // 在庫の方が献立の必要量より多い場合は残りの在庫量で判断
            //     if ($stockSum > $existingMenuSum) {
            //         $rest = $stockSum - $existingMenuSum;
            //         if ($quantity > $rest) {
            //             // 差分を買い物リストとして登録
            //             $quantity -= $rest;
            //             $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $quantity, $unitId);
            //         }
            //         // リクエストの必要量が在庫量を下回る場合はなにもしない
            //         // 在庫でまかなえるため
            //     }
            //     // そもそも今ある献立の必要量で在庫が足りていないなら、買い物リストを作成
            //     else {
            //         $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $quantity, $unitId);
            //     }
            // }
            // else {
            //     // 必要量が在庫量以上の場合は買い物リストに登録
            //     if ($stockSum > 0) {
            //         // 必要量の方が多い場合は買い物リストに登録
            //         if ($quantity > $stockSum) {
            //             $quantity -= $stockSum;
            //             $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $quantity, $unitId);
            //         }
            //     }
            //     else {
            //             $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $quantity, $unitId);
            //     }
            // }
                
        }
        
        return redirect('/menus/');
    }
    
    public function menu_edit(Menu $menu, Recipe $recipe)
    {
        return view('menus.menu_edit')->with(
            [
                'menu' => $menu,
                'recipes' => $recipe->get(),
                
            ]);
    }
    
    public function menu_update(MenuRequest $request, Menu $menu)
    {
        // *menusテーブルの保存*
        $input_menu = $request['menu'];
        $userId = $request->user()->id;
        $input_menu += array('user_id' => $userId);
        
        // $previousMenuIngredients = $menu->ingredients;
        
        // $menuId = $menu->id;
        
        $menu->fill($input_menu)->save();
        
        // dd($menu['ingredients']['0']['pivot']);
        $recipe = $menu->recipe;
        // dd($recipe);
        $ingredients = $recipe->ingredients;
        // dd($ingredients);
        
        $i = 0;
        $input_ingredient_menu = [];
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity / $recipe->number * $menu->number;
            $unitId = $ingredient->pivot->unit_id;
            // dd($ingredient->pivot->unit_id);
            $input_ingredient_menu[] = array(
                                            'ingredient_id' => $ingredient->id,
                                            'quantity' => $quantity,
                                            'unit_id' => $ingredient->pivot->unit_id,
                                        );
            
            // $slist = ShoppingList::firstOrNew(
            //         [
            //             'menu_id' => $menu->id,
            //             'ingredient_id' => $ingredient->id,
            //             'unit_id' => $ingredient->pivot->unit_id
            //         ]);
            
            // $stockSum = Stock::where('user_id', $userId)
            //             ->where('ingredient_id', $ingredient->id)
            //             ->where('unit_id', $unitId)
            //             ->whereNull('deleted_at')
            //             ->sum('quantity');
            
            // $slistSum = ShoppingList::where('user_id', $userId)
            //             ->where('ingredient_id', $ingredient->id)
            //             ->where('unit_id', $unitId)
            //             ->whereNull('deleted_at')
            //             ->sum('quantity');
            
            // $existingMenuSum = DB::table('ingredient_menu')
            //                     ->where('ingredient_id', $ingredient->id)
            //                     ->where('unit_id', $unitId)
            //                     ->where('menu_id', '!=', $menuId)
            //                     // 親テーブルが論理削除されていないものを取得
            //                     ->whereIn('menu_id', function ($query) use ($userId) {
            //                         $query->select('id')
            //                             ->from('menus')
            //                             ->where('user_id', $userId)
            //                             ->whereNull('deleted_at');
            //                     })
            //                     ->sum('quantity');
            // $existingMenuSum += $quantity;
            
            // // dd($stockSum, $slistSum, $existingMenuSum);
            
            // // 値を増やした場合
            // if ($quantity > $previousMenuIngredients["{$i}"]['pivot']['quantity']) {
            //     // 買い物リストが存在
            //     if ($slist->exists) { // O
            //         $difference = $quantity - $previousMenuIngredients["{$i}"]['pivot']['quantity'];
            //         $slistQuantity = $slist->quantity + $difference;
            //         $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $slistQuantity, $unitId);
            //     }
            //     // 買い物リストが存在しない
            //     else {
            //         // 必要量が在庫量を上回った場合
            //         if ($existingMenuSum > ($slistSum + $stockSum)) { // x
            //             $slistQuantity = $existingMenuSum - ($slistSum + $stockSum);
            //             $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $slistQuantity, $unitId);
            //         }
            //     }
            // }
            // // 値を減らした場合
            // else {
            //     if ($slist->exists) {
            //         $difference = $previousMenuIngredients["{$i}"]['pivot']['quantity'] - $quantity;
            //         if ($slist->quantity > $difference) { // O
            //             $slistQuantity = $slist->quantity - $difference;
            //             $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $slistQuantity, $unitId);
            //         }
            //         // 値を減らした結果, 買い物が必要なくなった
            //         else { // O
            //             $slist->delete();
            //         }
            //     }
            // }
            
            // if ($menu["ingredients"]["{$i}"]["pivot"]["ingredient_id"] !== $ingredient->id) {
            //     $menu->pivot->ingredient_id = 100;
            // }
            // dd($menu["ingredients"]["{$i}"]["pivot"]["ingredient_id"]);
            // $menu->ingredients()->updateExistingPivot($ingredient->id, [
            //         'quantity' => $quantity,
            //         'unit_id' => $ingredient->pivot->unit_id,
            //     ]);
            $i += 1;
        }
        // dd($input_ingredient_menu);
        $menu->ingredients()->sync($input_ingredient_menu);
        
        return redirect('/menus/');
    }
    
    public function menu_delete(Menu $menu)
    {
        // $userId = $menu->user_id;
        // $menuId = $menu->id;
        // $i = 0;
        // foreach ($menu->ingredients as $ingredient) {
        //     $slist = ShoppingList::where('user_id', $userId)
        //                     ->where('menu_id', $menuId)
        //                     ->where('status', 0)
        //                     ->first();
        //     if ($slist) {
        //         if ($ingredient['pivot']['quantity'] >= $slist->quantity) {
        //             $slist->delete();
        //         }
        //         // もしかしたらこの処理はいらないかも
        //         else {
        //             $slistQuantity = $slist->qunantity - $ingredient['pivot']['quantity'];
        //             $slist->saveShoppinglistByMenu($userId, $ingredient->id, $menuId, $slistQuantity, $ingredient["$i"]['pivot']['unit_id']);
        //         }
        //     }
        //     $i += 1;
        // }
        
        $menu->delete();
        
        return redirect('/menus');
    }
    
    public function menu_expired_delete()
    {
        $today = Carbon::today();
        
        echo $today, "\n";
        // 献立の日付が過ぎたものを取得
        $expiredMenus = Menu::whereDate('date', '<', $today)->get();
        
        
        foreach ($expiredMenus as $menu) {
            // 献立に紐づく材料の処理
            echo $menu, "\n";
            // echo $menu->pivot, "\n";
            foreach ($menu->ingredients as $ingredient) {
                // 在庫から材料の個数を引く
                echo "ingredient id", $ingredient->id, "\n";
                echo "unit id", $ingredient->pivot->unit_id, "\n";
                $stockItem = Stock::where('ingredient_id', $ingredient->id)
                                    ->where('unit_id', $ingredient->pivot->unit_id)
                                    ->first();
                echo $ingredient->pivot, "\n";
                echo $stockItem, "\n";
                echo $stockItem->quantity, "\n";
                if ($stockItem) {
                    // 在庫がある場合
                    $newQuantity = $stockItem->quantity - $ingredient->pivot->quantity;
                    echo "new quantity:", $newQuantity, "\n";
                    $stockItem->update(['quantity' => max(0, $newQuantity)]);
                }
            }

            // 献立を削除
            $menu->delete();
        }
        
    }
    
    public function menu_add2shoppinglist(Request $request, Menu $menu)
    {
        $previousIngredients = $menu->shopping_lists;
        $input_slists = $request['slist'];
        $userId = $menu->user_id;
        $menuId = $menu->id;
        
        $exists = ShoppingList::where('user_id', $userId)
                        ->where('menu_id', $menuId)
                        ->exists();
        
        $i = 0;
        foreach ($input_slists as $input_slist) {
            if ($exists) {
                if ($input_slist['quantity'] == $previousIngredients["{$i}"]->quantity) {
                    return response()->json(['message' => "買い物リストが既にあります。", 'data' => $previousIngredients["{$i}"]->quantity]);
                }
                else {
                    $slist = ShoppingList::where(
                        [
                            'user_id' => $input_slist['user_id'],
                            'ingredient_id' => $input_slist['ingredient_id'],
                            'menu_id' => $input_slist['menu_id'],
                            'unit_id' => $input_slist['unit_id'],
                            'deleted_at' => NULL,
                        ])->first();
                    $slist->fill($input_slist)->save();
                    return response()->json(['message' => "買い物リストを更新しました。", 'data' => $previousIngredients["{$i}"]->quantity]);
                }
            }
            else {
                $slist = new ShoppingList();
                $slist->fill($input_slist)->save();
            }
            $i += 1;
        }
        
        return response()->json(['message' => "買い物リストに追加しました。", 'data' => $previousIngredients["{$i}"]->quantity]);
    }
}

// $previousIngredients = $menu->ingredients;
//         $input_slists = $request['slist'];
//         $userId = $menu->user_id;
//         $menuId = $menu->id;
        
//         $exists = ShoppingList::where('user_id', $userId)
//                         ->where('menu_id', $menuId)
//                         ->whereNull('deleted_at')
//                         ->exists();
//         $i = 0;
//         foreach ($input_slists as $input_slist) {
//             if ($exists) {
//                 if ($input_slist['quantity'] == $previousIngredients["{$i}"]['pivot']['quantity']) {
//                     return response()->json(['message' => "買い物リストが既にあります。"]);
//                 }
//                 else {
//                     $slist = ShoppingList::firstOrNew(
//                         [
//                             'user_id' => $input_slist['user_id'],
//                             'ingredient_id' => $input_slist['ingredient_id'],
//                             'menu_id' => $input_slist['menu_id'],
//                             'unit_id' => $input_slist['unit_id'],
//                             'deleted_at' => NULL,
//                         ]);
//                     $slist->fill($input_slist)->save();
//                     return response()->json(['message' => "買い物リストを更新しました。"]);
//                 }
//             }
//             else {
//                 $slist = new ShoppingList();
//                 $slist->fill($input_slist)->save();
//                 return response()->json(['message' => "買い物リストに追加しました。"]);
//             }
//             $i += 1;
//         }