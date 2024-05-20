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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->unsignedInteger('company_id');
            $table->string('job_title');
            $table->date('date_of_birth')->nullable();
            $table->string('employment_status')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone_number')->nullable();
            $table->integer('user_created')->nullable();
            $table->integer('user_updated')->nullable();
            $table->text('notes')->nullable();


            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            // Buat constraint untuk kolom department_id
            $table->foreign('department_id')->references('id')->on('companies_departments')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('employee_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
