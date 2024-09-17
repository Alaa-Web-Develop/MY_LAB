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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
           
            $table->string('firstname');
            $table->string('lastname');

            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->string('pathology_report_image')->nullable();

            
            $table->foreignId('tumor_id')->nullable()->constrained('tumors')->nullOnDelete();

            
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('age')->nullable();
            
            $table->text('comment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
