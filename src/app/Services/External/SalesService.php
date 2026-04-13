<?php

namespace App\Services\External;

use App\Models\Sale;
use App\Services\BaseSyncService;

class SalesService extends BaseSyncService
{
    protected function endpoint(): string
    {
        return '/api/sales';
    }

    protected function model(): string
    {
        return Sale::class;
    }

    protected function map(array $sale): ?array
    {
        $id = $sale['g_number'] ?? $sale['sale_id'] ?? null;

        if (!$id) {
            return null;
        }

        return [
            'external_id' => (string) $id,
            'sale_id' => $sale['sale_id'] ?? null,
            'date' => $sale['date'] ?? null,
            'last_change_date' => $sale['last_change_date'] ?? null,

            'total_price' => isset($sale['total_price'])
                ? round((float)$sale['total_price'], 2)
                : null,

            'for_pay' => isset($sale['for_pay'])
                ? round((float)$sale['for_pay'], 2)
                : null,

            'finished_price' => isset($sale['finished_price'])
                ? round((float)$sale['finished_price'], 2)
                : null,

            'price_with_disc' => isset($sale['price_with_disc'])
                ? round((float)$sale['price_with_disc'], 2)
                : null,

            'discount_percent' => $sale['discount_percent'] ?? null,

            'warehouse_name' => $sale['warehouse_name'] ?? null,
            'region_name' => $sale['region_name'] ?? null,
            'brand' => $sale['brand'] ?? null,
            'barcode' => $sale['barcode'] ?? null,
            'nm_id' => $sale['nm_id'] ?? null,
        ];
    }
}
