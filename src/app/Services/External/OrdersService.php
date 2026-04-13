<?php

namespace App\Services\External;

use App\Models\Order;
use App\Services\BaseSyncService;

class OrdersService extends BaseSyncService
{
    protected function endpoint(): string
    {
        return '/api/orders';
    }

    protected function model(): string
    {
        return Order::class;
    }

    protected function map(array $order): ?array
    {
        $id = $order['g_number'] ?? null;

        if (!$id) {
            return null;
        }

        return [
            'external_id' => (string) $id,
            'date' => $order['date'] ?? null,
            'total_price' => isset($order['total_price'])
                ? round((float)$order['total_price'], 2)
                : null,
            'status' => isset($order['is_cancel'])
                ? ($order['is_cancel'] ? 'cancelled' : 'active')
                : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
