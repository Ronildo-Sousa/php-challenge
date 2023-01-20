<?php

namespace App\Actions\Products;

use App\Jobs\DowloadProductsJob;
use App\Jobs\ImportProductsJob;
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

        foreach ($this->fileNames as $key => $fileName) {
            $streamPath = $this->baseUrl . $fileName . '.json.gz';

            Bus::batch([
                [
                    new DowloadProductsJob($streamPath, $fileName . '.zip'),
                    new ImportProductsJob(base_path('/Cron/Products/' . $fileName . '.zip'), 10)
                ]
            ])->name("#$key Import-product")
                ->catch(function (Batch $batch, Throwable $e) {
                    // disparar email
                })->dispatch();
        }
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
