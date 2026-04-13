<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\External\StocksService;

class SyncStocks extends Command
{
    protected $signature = 'sync:stocks {dateFrom}';

    public function __construct(private StocksService $service)
    {
        parent::__construct();
    }

    public function handle()
    {
        $result = $this->service->sync(
            $this->argument('dateFrom')
        );

        $this->printSyncResult($result);
    }
}
