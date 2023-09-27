<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RakutenRecipeController;
use App\Http\Controllers\StockController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::post('/recipes', 'recipe_store')->name('recipe_store');
    Route::get('/recipes/getCategories', 'getCategories');
    Route::get('/recipes/create', 'recipe_create')->name('recipe_create');
    Route::get('/recipes/{recipe}', 'recipe_show')->name('recipe_show');
    Route::put('/recipes/{recipe}', 'recipe_update')->name('recipe_update');
    Route::delete('/recipes/{recipe}', 'recipe_delete')->name('recipe_delete');
    Route::get('/recipes/{recipe}/edit', 'recipe_edit')->name('recipe_edit');
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
