<?php

namespace App\Console\Commands;

use App\Http\Controllers\AdminCmsBackupsController;
use Illuminate\Console\Command;

class AutoBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        $this->info("> Starting...");
        $bu = new AdminCmsBackupsController;
        $bu->getProcess();
        $this->info("> Done...");
    }
}
