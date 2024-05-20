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
        Schema::create('accounts_balances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('balance');
            $table->foreignId('account_id')->constrained();
            $table->timestamps();
            $table->integer('user_created');
            $table->integer('user_updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_balances');
    }
};