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
        Schema::create('doctor_sponserd_tests', function (Blueprint $table) {
            $table->id();
            //id, doctor_id, sponsored_test_id, quota_remaining.
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('sponser_test_id')->constrained('sponser_tests')->onDelete('cascade');
            $table->integer('quota_remaining')->default(0); // Quota remaining for the doctor

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_sponserd_tests');
    }
};
