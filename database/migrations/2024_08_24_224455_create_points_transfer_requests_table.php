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
        Schema::create('points_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('points')->default(0);
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('transfer_type', ['instapay', 'vodafone_cach', 'orange_cach'])->default('instapay');

            $table->string('transfer_phone_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points_transfer_requests');
    }
};
