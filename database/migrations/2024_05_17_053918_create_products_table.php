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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('image_product')->default('https://res.cloudinary.com/boxity-id/image/upload/v1709745192/39b09e1f-0446-4f78-bbf1-6d52d4e7e4df.png');
            $table->decimal('price', 10, 2);
            $table->string('type')->nullable();
            $table->string('subtype')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('sku')->nullable();
            $table->integer('stock')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->boolean('raw_material')->default(false);
            $table->string('unit_of_measure')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->integer('user_created')->nullable();
            $table->integer('user_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
