<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'external_id',
        'sale_id',
        'date',
        'last_change_date',
        'total_price',
        'for_pay',
        'finished_price',
        'price_with_disc',
        'discount_percent',
        'warehouse_name',
        'region_name',
        'brand',
        'barcode',
        'nm_id',
    ];
}
