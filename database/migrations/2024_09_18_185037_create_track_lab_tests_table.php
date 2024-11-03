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
        Schema::create('track_lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_order_id')->constrained('lab_orders')->cascadeOnDelete();
            $table->foreignId('courier_collected_test_id')->nullable()->constrained('courier_collected_tests')->onDelete('cascade');

            $table->timestamp('expected_result_released_date')->nullable();
            $table->enum('status',['ordered','collected_by_courier','lab_received_at'])->default('ordered');
            // $table->timestamp('collected_by_courier_at')->nullable();
            $table->timestamp('lab_received_at')->nullable();
            $table->timestamp('result_released_at')->nullable();

            $table->json('result')->nullable(); // Store results as JSON to handle multiple files
            $table->text('notes')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_lab_tests');
    }
};
