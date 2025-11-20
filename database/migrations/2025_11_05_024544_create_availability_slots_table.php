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
    Schema::create('availability_slots', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lawyer_id')->constrained('users')->onDelete('cascade');
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('availability_slots');
    }
};
