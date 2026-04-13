<?php

namespace App\Services\External;

use App\Models\Income;
use App\Services\BaseSyncService;

class IncomesService extends BaseSyncService
{
    protected function endpoint(): string
    {
        return '/api/incomes';
    }

    protected function model(): string
    {
        return Income::class;
    }

    protected function map(array $income): ?array
    {
        $id = $income['income_id'] ?? null;

        if (!$id) {
            return null;
        }

        return [
            'external_id' => (string) ($income['income_id'] ?? null),
            'income_id' => $income['income_id'] ?? null,
            'number' => $income['number'] ?? null,
            'date' => $income['date'] ?? null,
            'last_change_date' => $income['last_change_date'] ?? null,
            'date_close' => $income['date_close'] ?? null,
            'supplier_article' => $income['supplier_article'] ?? null,
            'tech_size' => $income['tech_size'] ?? null,
            'barcode' => $income['barcode'] ?? null,
            'nm_id' => $income['nm_id'] ?? null,
            'quantity' => $income['quantity'] ?? null,
            'total_price' => $income['total_price'] ?? null,
            'warehouse_name' => $income['warehouse_name'] ?? null,
        ];
    }
}
