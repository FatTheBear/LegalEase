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
        Schema::table('appointments', function (Blueprint $table) {
            // Thay đổi enum status từ ['booked', 'cancelled', 'rescheduled'] 
            // thành ['pending', 'confirmed', 'completed', 'cancelled']
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['booked', 'cancelled', 'rescheduled'])
                  ->default('booked')
                  ->change();
        });
    }
};
