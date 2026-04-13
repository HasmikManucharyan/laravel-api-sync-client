<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\External\SalesService;

class SyncSales extends Command
{
    protected $signature = 'sync:sales {dateFrom} {dateTo}';

    public function __construct(private SalesService $service)
    {
        parent::__construct();
    }

    public function handle()
    {
        $result = $this->service->sync(
            $this->argument('dateFrom'),
            $this->argument('dateTo')
        );

        $this->printSyncResult($result);
    }
}
