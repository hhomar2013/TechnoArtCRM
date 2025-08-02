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
        Schema::create('instllment_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customersId')->nullable()->constrained('customers')->onDelete('cascade');
            $table->foreignId('installment_plan_id')->nullable()->constrained('installment_plans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instllment_customers');
    }
};
