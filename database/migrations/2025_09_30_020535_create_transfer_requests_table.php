<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installment_plan_id')->constrained('installment_plans');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('old_project_id')->constrained('projects');
            $table->foreignId('new_project_id')->constrained('projects');
            $table->foreignId('old_phase_id')->constrained('phases');
            $table->foreignId('new_phase_id')->constrained('phases');
            $table->decimal('costs_total', 10, 2);
            $table->decimal('payment_total', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('transferred');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};
