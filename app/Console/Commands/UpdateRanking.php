<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RakutenRecipeController;

class UpdateRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '"Updates the popularity rankings of Rakuten Recipes.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app(RakutenRecipeController::class)->getRanking();
        $this->info('Popularity rankings of Rakuten Recipes updated successfully.');
    }
}
