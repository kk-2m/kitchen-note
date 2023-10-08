<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use Carbon\Carbon;
use App\Models\Recipe;
use App\Models\Menu;

class MenuController extends Controller
{
    public function menu_index(Menu $menu)
    {
        $now = Carbon::today();
        $weekLater = $now->copy()->addWeek();
        
        $menu->get();
        
        return view('menus.menu_index')->with(
            [
                'menus' => $menu
                            ->where('date', '>=', $now)
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
        $input_menu += array('user_id' => $request->user()->id);
        $menu->fill($input_menu)->save();
        
        $recipe = $menu->recipe;
        $ingredients = $recipe->ingredients;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity / $recipe->number * $menu->number;
            $menu->ingredients()->syncWithoutDetaching(
                    [
                        $ingredient->pivot->ingredient_id=>[
                                'quantity' => $quantity,
                                'unit_id' => $ingredient->pivot->unit_id,
                            ]
                    ]);
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
        $input_menu += array('user_id' => $request->user()->id);
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
            // dd($ingredient->pivot->unit_id);
            $input_ingredient_menu[] = array(
                                            'ingredient_id' => $ingredient->id,
                                            'quantity' => $quantity,
                                            'unit_id' => $ingredient->pivot->unit_id,
                                        );
            
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
        $menu->delete();
        return redirect('/menus');
    }
}
