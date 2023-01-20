<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $products;

    public function __construct(
        public string $zipFilePath,
        public int $productsAmount = 100
    ) {
        $this->products = collect([]);
    }

    public function handle()
    {
        $productsFile = gzfile($this->zipFilePath);

        $numProducts = 0;
        $i = 0;

        while ($numProducts < $this->productsAmount) {
            if ($i >= count($productsFile)) {
                break;
            }

            $product = json_decode($productsFile[$i]);
            $product->code = str_replace('"', '', $product->code);
            $isImported = $this->isImported($product->code);

            if (!$isImported) {
                ImportSingleProductJob::dispatch(collect($product)->toArray());

                $this->products->add($product->code);
                $numProducts++;
            }
            $i++;
        }
    }

    public function isImported(string $code)
    {
        return $this->products->contains($code);
    }
}
