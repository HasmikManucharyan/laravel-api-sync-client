<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->string('external_id')->unique();

            $table->bigInteger('nm_id')->nullable();
            $table->bigInteger('sc_code')->nullable();

            $table->string('warehouse_name')->nullable();

            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();

            $table->integer('quantity_full')->nullable();

            $table->integer('in_way_to_client')->nullable();
            $table->integer('in_way_from_client')->nullable();

            $table->boolean('is_supply')->nullable();
            $table->boolean('is_realization')->nullable();

            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
