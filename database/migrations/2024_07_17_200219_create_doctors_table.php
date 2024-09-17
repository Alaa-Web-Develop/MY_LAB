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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');

            
            $table->foreignId('speciality_id')->nullable()->constrained('specialities')->nullOnDelete();
            // $table->unsignedBigInteger('speciality_id');
            // $table->foreign('speciality_id')->references('id')->on('specialities')->nullOnDelete();
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->nullOnDelete();
            // $table->foreignId('governorate_id')->nullable()->constrained('governorates')->cascadeOnDelete();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // $table->foreignId('city_id')->nullable()->constrained('cities')->cascadeOnDelete();
            $table->enum('Approval_Status', ['pending', 'approved'])->default('pending');
            $table->enum('source', ['mobile', 'admin'])->default('admin');


            $table->unsignedBigInteger('governorate_id');
            // $table->foreign('governorate_id')->nullable()->references('id')->on('governorates')->cascadeOnDelete();

            $table->unsignedBigInteger('city_id');
            // $table->foreign('city_id')->nullable()->references('id')->on('cities')->cascadeOnDelete();

            $table->string('random_number')->nullable();

            $table->integer('total_points')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
