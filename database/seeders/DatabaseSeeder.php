<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RecipeSeeder;
use Database\Seeders\ProcedureSeeder;
use Database\Seeders\IngredientCategorySeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\IngredientSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\ShoppingListSeeder;
use Database\Seeders\StockSeeder;
use Database\Seeders\CategoryRecipeSeeder;
use Database\Seeders\IngredientRecipeSeeder;
use Database\Seeders\UnitSeeder;
use Database\Seeders\UnitConversionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(RecipeSeeder::class);
        $this->call(ProcedureSeeder::class);
        $this->call(IngredientCategorySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(IngredientSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ShoppingListSeeder::class);
        $this->call(StockSeeder::class);
        $this->call(CategoryRecipeSeeder::class);
        $this->call(IngredientRecipeSeeder::class);
        $this->call(UnitConversionSeeder::class);
    }
}
