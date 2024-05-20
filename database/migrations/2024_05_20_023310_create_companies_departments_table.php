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
        Schema::create('companies_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('responsibilities')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
            $table->integer('user_created')->nullable();
            $table->integer('user_updated')->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies_departments');
    }
};
