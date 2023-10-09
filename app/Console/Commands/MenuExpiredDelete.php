<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MenuController;

class MenuExpiredDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:expired-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired menus and update stock';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app(MenuController::class)->menu_expired_delete();
        $this->info('Expired menus deleted successfully.');
    }
}
