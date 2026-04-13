<?php

namespace App\Console\Commands\Traits;

trait SyncPrinter
{
    protected function printSyncResult(array $result): void
    {
        $this->line('');
        $this->info('Sync completed');

        $this->line("Fetched: {$result['fetched']}");
        $this->line("Processed: {$result['processed']}");

        if (!empty($result['skipped'])) {
            $this->warn("Skipped: {$result['skipped']}");
        }

        $this->line('');
    }
}
