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
        Schema::create('punishes', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 20, 2)->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('notes')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punishes');
    }
};
