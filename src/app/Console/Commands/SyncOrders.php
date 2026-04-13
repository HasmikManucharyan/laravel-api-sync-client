<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\External\OrdersService;
use App\Console\Commands\Traits\SyncPrinter;
class SyncOrders extends Command
{
    use SyncPrinter;
    protected $signature = 'sync:orders {dateFrom} {dateTo}';

    public function __construct(private OrdersService $service)
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
