<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('lawyer_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('slot_id')->constrained('availability_slots')->onDelete('cascade');
        $table->dateTime('appointment_time');
        $table->enum('status', ['booked', 'cancelled', 'rescheduled'])->default('booked');
        $table->text('note')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
