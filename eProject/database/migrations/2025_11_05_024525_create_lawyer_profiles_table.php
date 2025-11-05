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
    Schema::create('lawyer_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('specialization', 50);
        $table->integer('experience')->nullable();
        $table->string('city', 50)->nullable();
        $table->string('province', 50)->nullable();
        $table->boolean('verified')->default(false);
        $table->float('rating')->default(0);
        $table->text('bio')->nullable();
        $table->string('avatar', 255)->nullable();
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
        Schema::dropIfExists('lawyer_profiles');
    }
};
