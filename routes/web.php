<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\RakutenRecipeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [RecipeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(RecipeController::class)->middleware(['auth'])->group(function(){
    Route::get('/recipes', 'recipe_index')->name('recipe_index');
    Route::post('/recipes', 'recipe_store')->name('recipe_store');
    Route::get('/recipes/getCategories', 'getCategories');
    Route::get('/recipes/create', 'recipe_create')->name('recipe_create');
    Route::get('/recipes/{recipe}', 'recipe_show')->name('recipe_show');
    Route::put('/recipes/{recipe}', 'recipe_update')->name('recipe_update');
    Route::delete('/recipes/{recipe}', 'recipe_delete')->name('recipe_delete');
    Route::get('/recipes/{recipe}/edit', 'recipe_edit')->name('recipe_edit');
});

Route::controller(StockController::class)->middleware(['auth'])->group(function(){
    Route::get('/stocks', 'stock_index')->name('stock_index');
    Route::post('/stocks', 'stock_store')->name('stock_store');
    Route::get('/stocks/create', 'stock_create')->name('stock_create');
    Route::put('/stocks/{stock}', 'stock_update')->name('stock_update');
    Route::delete('/stocks/{stock}', 'stock_delete')->name('stock_delete');
    Route::get('/stocks/{stock}/edit', 'stock_edit')->name('stock_edit');
});

Route::controller(MenuController::class)->middleware(['auth'])->group(function(){
    Route::get('/menus', 'menu_index')->name('menu_index');
    Route::post('/menus', 'menu_store')->name('menu_store');
    Route::get('/menus/create', 'menu_create')->name('menu_create');
    Route::put('/menus/{menu}', 'menu_update')->name('menu_update');
    Route::put('/menus/{menu}/add2shoppinglist', 'menu_add2shoppinglist')->name('menu_add2shoppinglist');
    Route::delete('/menus/{menu}', 'menu_delete')->name('menu_delete');
    Route::get('/menus/{menu}/edit', 'menu_edit')->name('menu_edit');
});

Route::controller(ShoppingListController::class)->middleware(['auth'])->group(function(){
    Route::get('/shoppinglists', 'shoppinglist_index')->name('shoppinglist_index');
    Route::post('/shoppinglists', 'shoppinglist_store')->name('shoppinglist_store');
    Route::get('/shoppinglists/seach', 'shoppinglist_search')->name('shoppinglist_search');
    Route::put('/shoppinglists/{slist}', 'shoppinglist_update')->name('shoppinglist_update');
    Route::put('/shoppinglists/{slist}/status', 'shoppinglist_updateStatus')->name('shoppinglist_updateStatus');
    Route::delete('/shoppinglists/{slist}', 'shoppinglist_delete')->name('shoppinglist_delete');
    Route::get('/shoppinglists/{slist}/edit', 'shoppinglist_edit')->name('shoppinglist_edit');
});

Route::controller(RakutenRecipeController::class)->middleware(['auth'])->group(function(){
    Route::get('/rakuten-recipes', 'category')->name('rakuten-recipe_category');
    Route::post('/rakuten-recipes', 'recipe_store')->name('rakuten-recipe_store');
    Route::get('/rakuten-recipes/{category}', 'recipe_index')->name('rakuten-recipe_index');
    Route::get('/rakuten-recipes/{rakuten_recipe_category}/{rakuten_recipe}', 'recipe_show')->name('rakuten-recipe_show');
    Route::get('/rakuten-recipes/{rakuten_recipe_category}/{rakuten_recipe}/edit', 'recipe_edit')->name('rakuten-recipe_edit');
});

// Route::get('/categories/{category}', [CategoryController::class,'index'])->middleware("auth");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
