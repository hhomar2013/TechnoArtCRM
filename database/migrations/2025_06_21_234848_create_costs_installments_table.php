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
        Schema::create('costs_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_id')->nullable()->constrained('costs')->onDelete('cascade');
            $table->foreignId('installment_plan_id')->nullable()->constrained('installment_plans')->onDelete('cascade');
            $table->string('bank')->nullable();
            $table->string('time')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('date')->nullable();
            $table->decimal('value', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costs_installments');
    }
};
