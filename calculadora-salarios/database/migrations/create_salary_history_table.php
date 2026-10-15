<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('salary_histories', function (Blueprint $table) {
        $table->id();
        $table->decimal('gross_salary', 10, 2);
        $table->decimal('employee_isss', 10, 2);
        $table->decimal('employee_afp', 10, 2);
        $table->decimal('taxable_base', 10, 2);
        $table->decimal('income_tax', 10, 2);
        $table->decimal('net_salary', 10, 2);
        $table->decimal('employer_isss', 10, 2);
        $table->decimal('employer_afp', 10, 2);
        $table->decimal('employer_cost', 10, 2);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('salary_histories');
}

};