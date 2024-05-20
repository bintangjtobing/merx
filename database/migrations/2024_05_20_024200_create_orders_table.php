<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->enum('status', ['Pending Confirmation', 'In Production', 'Packaging', 'Completed', 'Cancelled', 'Shipped']);
            $table->text('details')->nullable();
            $table->string('unit_of_measure')->default('pcs');
            $table->integer('taxes')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('total_price');
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};