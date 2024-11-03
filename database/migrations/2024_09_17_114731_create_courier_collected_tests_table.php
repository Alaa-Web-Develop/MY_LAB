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
        Schema::create('courier_collected_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_id')->constrained('couriers')->Ondelete('cascade');
            $table->foreignId('lab_order_id')->constrained('lab_orders')->Ondelete('cascade');
            $table->enum('status',['new','collected'])->default('new');
            $table->timestamp('collected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_collected_tests');
    }
};
