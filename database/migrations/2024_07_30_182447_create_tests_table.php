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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('tumor_id')->nullable()->constrained('tumors')->nullOnDelete();

            $table->text('details')->nullable();
            $table->enum('status',['valid','invalid'])->default('valid');
            // $table->enum('type',['test','rays'])->default('test');

                 $table->json('questions')->nullable(); // Add questions column
                 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
