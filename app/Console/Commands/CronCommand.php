<?php

namespace App\Console\Commands;

use App\Actions\Products\ImportFromOpenFoodFacts;
use Illuminate\Console\Command;

class CronCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from Open Food Facts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new ImportFromOpenFoodFacts)->run();
    }
}
