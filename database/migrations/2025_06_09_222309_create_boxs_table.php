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
        Schema::create('boxs', function (Blueprint $table) {
            $table->id();
            $table->boolean('in_or_out')->default(false); // false for in, true for out
            $table->decimal('value',20,2)->nullable();
            $table->string('notes')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boxs');
    }
};
