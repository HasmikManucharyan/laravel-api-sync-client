<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\External\IncomesService;

class SyncIncomes extends Command
{
    protected $signature = 'sync:incomes {dateFrom} {dateTo}';

    public function __construct(private IncomesService $service)
    {
        parent::__construct();
    }

    public function handle()
    {
        $result = $this->service->sync(
            $this->argument('dateFrom'),
            $this->argument('dateTo')
        );

        $result = $this->service->sync($from, $to);

        $this->printSyncResult($result);
    }
}
