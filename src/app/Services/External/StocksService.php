<?php

namespace App\Services\External;

use App\Models\Stock;
use App\Services\BaseSyncService;

class StocksService extends BaseSyncService
{
    protected function endpoint(): string
    {
        return '/api/stocks';
    }

    protected function model(): string
    {
        return Stock::class;
    }

    protected function map(array $stock): ?array
    {
        $nmId = $stock['nm_id'] ?? null;

        if (!$nmId) {
            return null;
        }

        $warehouse = $stock['warehouse_name'] ?? 'unknown';

        return [
            'external_id' => $nmId . '_' . $warehouse,

            'nm_id' => $nmId,
            'sc_code' => $stock['sc_code'] ?? null,

            'warehouse_name' => $warehouse,

            'subject' => $stock['subject'] ?? null,
            'category' => $stock['category'] ?? null,
            'brand' => $stock['brand'] ?? null,

            'quantity_full' => $stock['quantity_full'] ?? null,
            'in_way_to_client' => $stock['in_way_to_client'] ?? null,
            'in_way_from_client' => $stock['in_way_from_client'] ?? null,

            'is_supply' => $stock['is_supply'] ?? null,
            'is_realization' => $stock['is_realization'] ?? null,

            'price' => isset($stock['price'])
                ? (float) $stock['price']
                : null,

            'discount' => isset($stock['discount'])
                ? (float) $stock['discount']
                : null,
        ];
    }}
