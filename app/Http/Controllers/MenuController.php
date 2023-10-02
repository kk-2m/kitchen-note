<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Menu;

class MenuController extends Controller
{
    public function menu_index(Menu $menu)
    {
        $now = Carbon::today();
        $weekLater = $now->copy()->addWeek();
        
        // dd($weekLater);
        
        return view('menus.menu_index')->with(
            [
                'menus' => $menu->where('date', '>=', $now)->where('date', '<', $weekLater)->orderBy('date', 'ASC')->get(),
            ]);
    }
}
