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
        Schema::table('points_transfer_requests', function (Blueprint $table) {
            $table->integer('money')->nullable()->comment('Amount of money requested for transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('points_transfer_requests', function (Blueprint $table) {
            //
        });
    }
};
