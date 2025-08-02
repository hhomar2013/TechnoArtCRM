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
        Schema::create('installment_plans', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('customer_id');
            $table->json('customers')->nullable();
            $table->unsignedBigInteger('payment_plan_id')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('phase_id')->nullable()->constrained('phases')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2); // السعر الكلي
            $table->decimal('down_payment_total', 10, 2); // قيمة المقدم الفعلي
            $table->integer('down_payment_parts')->default(4); // عدد دفعات المقدم
            $table->string('status')->default('pending');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // pending, active, completed
            $table->timestamps();

            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('payment_plan_id')->references('id')->on('payment_plans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_plans');
    }
};
