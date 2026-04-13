<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'external_id',
        'nm_id',
        'sc_code',
        'warehouse_name',
        'subject',
        'category',
        'brand',
        'quantity_full',
        'in_way_to_client',
        'in_way_from_client',
        'is_supply',
        'is_realization',
        'price',
        'discount',
    ];
}
