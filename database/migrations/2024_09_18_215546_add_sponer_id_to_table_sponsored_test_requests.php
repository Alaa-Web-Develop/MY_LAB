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
        Schema::table('sponsored_test_requests', function (Blueprint $table) {
            $table->foreignId('sponser_id')->constrained('sponsers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsored_test_requests', function (Blueprint $table) {
            $table->dropForeignIdFor('sponser_id');
        });
    }
};
