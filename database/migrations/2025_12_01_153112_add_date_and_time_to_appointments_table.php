<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('date')->nullable()->after('slot_id');
            $table->time('start_time')->nullable()->after('date');

            // Chuyển end_time từ datetime → time
            $table->time('end_time')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['date', 'start_time']);
            $table->dateTime('end_time')->change();
        });
    }
};
