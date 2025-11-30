<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // BƯỚC 1: XÓA FOREIGN KEY TRƯỚC (nếu có)
        Schema::table('ratings', function (Blueprint $table) {
            // Xóa foreign key nếu tồn tại
            $table->dropForeign(['lawyer_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['appointment_id']);
        });

        // BƯỚC 2: XÓA INDEX CŨ
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique(['lawyer_id', 'client_id']);
        });

        // BƯỚC 3: TẠO LẠI FOREIGN KEY (an toàn)
        Schema::table('ratings', function (Blueprint $table) {
            $table->foreign('lawyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });

        // BƯỚC 4: TẠO UNIQUE MỚI CHỈ TRÊN appointment_id
        Schema::table('ratings', function (Blueprint $table) {
            $table->unique('appointment_id');
        });
    }

    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique(['appointment_id']);
            $table->dropForeign(['appointment_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['lawyer_id']);

            $table->unique(['lawyer_id', 'client_id']);
            $table->foreign('lawyer_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('appointment_id')->references('id')->on('appointments');
        });
    }
};