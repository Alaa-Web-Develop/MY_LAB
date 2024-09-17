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
        Schema::create('lab_tests', function (Blueprint $table) {
           
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->foreignId('lab_id')->constrained('labs')->cascadeOnDelete();


            $table->decimal('price',8,2)->default(0.00);
            $table->integer('discount_points')->default(0);
            $table->integer('points')->default(0);
            $table->text('notes')->nullable();

            // Add nullable foreign key for courier_id
            $table->foreignId('courier_id')->nullable()->constrained('couriers')->nullOnDelete();
            // Add has_courier boolean column
            $table->boolean('has_courier')->default(false);

            $table->primary(['lab_id','test_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_branche_test');
    }
};
