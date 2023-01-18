<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $filename;


    public function __construct(
        public string $zipFilePath,
        public int $productsAmount = 100
    ) {
        $this->filename = base_path('/Cron/Products/importedProducts.json');
    }

    public function handle()
    {
        $products = collect();
        $productsFile = gzfile($this->zipFilePath);

        $numProducts = 0;
        $i = 0;
        while ($numProducts < $this->productsAmount) {
            $product = json_decode($productsFile[$i]);
            $product->code = str_replace('"', '', $product->code);
            $isImported = $this->isImported($product->code);

            if (!$isImported) {
                $products->add([
                    'code' => $product->code,
                    'url' => $product->url,
                    'creator' => $product->creator,
                    'created_t' => $product->created_t,
                    'last_modified_t' => $product->last_modified_t,
                    'product_name' => $product->product_name,
                    'quantity' => $product->quantity,
                    'brands' => $product->brands,
                    'categories' => $product->categories,
                    'labels' => $product->labels,
                    'cities' => $product->cities,
                    'purchase_places' => $product->purchase_places,
                    'stores' => $product->stores,
                    'ingredients_text' => $product->ingredients_text,
                    'traces' => $product->traces,
                    'serving_size' => $product->serving_size,
                    'serving_quantity' => $product->serving_quantity,
                    'nutriscore_score' => $product->nutriscore_score,
                    'nutriscore_grade' => $product->nutriscore_grade,
                    'main_category' => $product->main_category,
                    'image_url' => $product->image_url,
                ]);
                $this->saveProductCode(['code' => $product->code]);
                $numProducts++;
            }
            $i++;
        }

        $products->each(fn ($product) => ImportSingleProductJob::dispatch($product));
    }

    public function isImported(string $code)
    {
        if (!file_exists($this->filename)) {
            file_put_contents($this->filename, '[]');
            return false;
        }
        $rawCodes = file_get_contents($this->filename);
        $codes = json_decode($rawCodes);

        return collect($codes)->contains('code', $code);
    }

    public function saveProductCode(array $data)
    {
        if (!file_exists($this->filename)) {
            file_put_contents($this->filename, '[' . json_encode($data) . ']');
            return;
        }

        $currentFile = file_get_contents($this->filename);
        $content = json_decode($currentFile);
        $content[] = $data;

        file_put_contents($this->filename, json_encode($content));
    }
}
