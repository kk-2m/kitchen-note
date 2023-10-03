<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    
    public function menu_create(Recipe $recipe)
    {
        return view('menus.menu_create')->with(
            [
                'recipes' => $recipe->get(),
            ]);
    }
    
    public function menu_store(Request $request, Menu $menu)
    {
        $input_menu = $request['menu'];
        $input_menu += array('user_id' => $request->user()->id);
        $menu->fill($input_menu)->save();
        
        $recipe = $menu->recipe;
        $ingredients = $recipe->ingredients;
        $i = 0;
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient->pivot->quantity / $recipe->number * $menu->number;
            $menu->ingredients()
                ->syncWithoutDetaching([
                    $ingredient->pivot->ingredient_id=>[
                        'quantity' => $quantity,
                        'unit_id' => $ingredient->pivot->unit_id]
                    ]);
            $i += 1;
        }
        dd($menu->ingredients);
        
        return redirect('/menus/');
    }
}
