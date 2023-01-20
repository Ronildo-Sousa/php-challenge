<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use function PHPUnit\Framework\directoryExists;

class DowloadProductsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public string $streamPath,
        public string $fileName,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): bool
    {
        $filePath = base_path("Cron/Products/");

        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
        }
        $this->fileName = $filePath . $this->fileName;

        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }

        $data = '';
        $handle = fopen($this->streamPath, 'rb');
        $filePath = fopen($this->fileName, 'w');
        if ($handle === false) {
            return false;
        }
        while (!feof($handle)) {
            $data = fread($handle, (1024 * 1024));
            fwrite($filePath, $data, strlen($data));
        }
        $result = fclose($handle);
        fclose($filePath);
        return $result;
    }
}
