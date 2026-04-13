<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->string('external_id')->unique();

            $table->string('sale_id')->nullable();

            $table->date('date')->nullable();
            $table->date('last_change_date')->nullable();

            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('for_pay', 12, 2)->nullable();
            $table->decimal('finished_price', 12, 2)->nullable();
            $table->decimal('price_with_disc', 12, 2)->nullable();

            $table->integer('discount_percent')->nullable();

            $table->string('warehouse_name')->nullable();
            $table->string('region_name')->nullable();

            $table->string('brand')->nullable();
            $table->string('barcode')->nullable();
            $table->bigInteger('nm_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
