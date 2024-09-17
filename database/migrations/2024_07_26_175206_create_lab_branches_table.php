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
        Schema::create('lab_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('lab_id')->constrained('labs')->cascadeOnDelete();
            $table->string('phone');
            $table->string('hotline')->nullable();
            $table->string('email')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('Approval_Status', ['pending', 'approved'])->default('pending');

            $table->unsignedBigInteger('governorate_id');
            $table->unsignedBigInteger('city_id');
            $table->string('address')->nullable();

            $table->string('location')->nullable();

            $table->text('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_branches');
    }
};
