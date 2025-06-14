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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('installment_plan_id');
            $table->decimal('amount', 10, 2);
            $table->date('due_date'); // تاريخ الاستحقاق
            $table->date('paid_at')->nullable(); // إذا تم الدفع
            $table->enum('type', ['down_payment', 'installment']); // نوع الدفعة
            $table->string('status')->default('pending'); // paid, pending, late
            $table->timestamps();

            $table->foreign('installment_plan_id')->references('id')->on('installment_plans')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
