<?php

namespace App\Actions\Products;

use App\Jobs\DowloadProductsJob;
use App\Jobs\ImportProductsJob;
use App\Models\User;
use App\Notifications\CronJobNotification;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class ImportFromOpenFoodFacts
{
    private string $baseUrl = "https://challenges.coode.sh/food/data/json/";
    private array $fileNames = [];

    public function run()
    {
        $this->getFileNames();

        $jobs = [];
        foreach ($this->fileNames as $fileName) {
            $streamPath = $this->baseUrl . $fileName . '.json.gz';
            $jobs[] = [
                new DowloadProductsJob($streamPath, $fileName . '.zip'),
                new ImportProductsJob(base_path('/Cron/Products/' . $fileName . '.zip'))
            ];
        }

        Bus::batch($jobs)->name("Import-products")
            ->finally(function (Batch $batch) {
                User::admin()
                    ->each(
                        fn ($user) => $user->notify(
                            new CronJobNotification('Cron Job ' . $batch->name . 'executed successfully')
                        )
                    );
            })
            ->catch(function (Batch $batch, Throwable $e) {
                User::admin()
                    ->each(
                        fn ($user) => $user->notify(
                            new CronJobNotification(
                                'Error on Cron Job ' . $batch->name,
                                $e->getMessage()
                            )
                        )
                    );
            })->dispatch();
    }

    private function getFileNames()
    {
        $response = Http::get($this->baseUrl . 'index.txt')->body();
        $names = Str::of($response)->explode('.json.gz');

        foreach ($names as $name) {
            if (strlen($name) > 1) {
                if ($name[0] !== "p") {
                    $this->fileNames[] = substr($name, 1);
                } else {
                    $this->fileNames[] = $name;
                }
            }
        }
    }
}
