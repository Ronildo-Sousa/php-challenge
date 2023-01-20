<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $Importedfilename;

    public function __construct(
        public string $zipFilePath,
        public int $productsAmount = 100,
    ) {
        $this->Importedfilename = base_path('/Cron/Products/importedProducts.json');
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

            $importedCodes = $this->getImportedCodes();
            $product = json_decode($productsFile[$i]);
            $product->code = str_replace('"', '', $product->code);
            $isImported = $importedCodes->contains('code', $product->code);

            if (!$isImported) {
                ImportSingleProductJob::dispatch(collect($product)->toArray());

                $this->saveProductCode(['code' => $product->code]);
                $numProducts++;
            }
            $i++;
        }
    }

    public function getImportedCodes()
    {
        if (!file_exists($this->Importedfilename)) {
            file_put_contents($this->Importedfilename, '[]');
            return false;
        }
        $rawCodes = file_get_contents($this->Importedfilename);
        $codes = json_decode($rawCodes);

        return collect($codes);
    }

    public function saveProductCode(array $data)
    {
        if (!file_exists($this->Importedfilename)) {
            file_put_contents($this->Importedfilename, '[' . json_encode($data) . ']');
            return;
        }

        $currentFile = file_get_contents($this->Importedfilename);
        $content = json_decode($currentFile);
        $content[] = $data;

        file_put_contents($this->Importedfilename, json_encode($content));
    }
}
