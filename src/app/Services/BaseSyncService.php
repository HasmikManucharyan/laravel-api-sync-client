<?php

namespace App\Services;

use App\Services\Api\ApiClient;
use Illuminate\Support\Facades\DB;

abstract class BaseSyncService
{
    public function __construct(protected ApiClient $client) {}

    abstract protected function endpoint(): string;

    abstract protected function map(array $item): ?array;

    abstract protected function model(): string;

    protected function uniqueKey(): string
    {
        return 'external_id';
    }
    protected function queryParams(string $from, ?string $to = null): array
    {
        return array_filter([
            'dateFrom' => $from,
            'dateTo' => $to,
        ]);
    }

    public function sync(string $from, ?string $to = null): array
    {
        $items = $this->client->getPaginated(
            $this->endpoint(),
            $this->queryParams($from, $to)
        );

        if (empty($items)) {
            return [
                'fetched' => 0,
                'processed' => 0,
                'saved' => 0,
                'skipped' => 0,
            ];
        }

        $rows = [];

        foreach ($items as $item) {
            $mapped = $this->map($item);

            if (!empty($mapped)) {
                $rows[] = $mapped;
            }
        }

        $fetched = count($items);
        $processed = count($rows);
        $saved = 0;
        $skipped = 0;

        if (empty($rows)) {
            return [
                'fetched' => $fetched,
                'processed' => 0,
                'saved' => 0,
                'skipped' => $fetched,
            ];
        }

        $modelClass = $this->model();
        $uniqueKey = $this->uniqueKey();

        foreach (array_chunk($rows, 300) as $chunk) {

            if (empty($chunk)) {
                continue;
            }

            $first = $chunk[0] ?? null;

            if (!$first || empty($first[$uniqueKey])) {
                $skipped += count($chunk);
                logger()->warning('Bad chunk skipped', $first ?? []);
                continue;
            }

            $updateFields = array_keys($first);
            $updateFields = array_values(array_diff($updateFields, [$uniqueKey]));

            if (empty($updateFields)) {
                $skipped += count($chunk);
                logger()->warning('No update fields', $first);
                continue;
            }

            try {
                DB::transaction(function () use ($modelClass, $chunk, $uniqueKey, $updateFields) {
                    $modelClass::upsert(
                        $chunk,
                        [$uniqueKey],
                        $updateFields
                    );
                });

                $saved += count($chunk); // ✅ считаем только успешные

            } catch (\Throwable $e) {
                $skipped += count($chunk);

                logger()->error('Upsert failed', [
                    'error' => $e->getMessage(),
                    'sample' => $chunk[0] ?? null,
                ]);
            }
        }

        return [
            'fetched' => $fetched,
            'processed' => $processed,
            'saved' => $saved,
            'skipped' => $skipped,
        ];
    }
}
