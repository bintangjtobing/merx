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
        Schema::create('vendor_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendors_id');
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();

            $table->foreign('vendors_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->integer('user_created');
            $table->integer('user_updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_contacts');
    }
};