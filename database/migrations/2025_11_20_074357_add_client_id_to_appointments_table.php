<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Chỉ thêm cột client_id nếu chưa tồn tại
            if (!Schema::hasColumn('appointments', 'client_id')) {
                $table->unsignedBigInteger('client_id')->after('id');
                $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            }

            // lawyer_id chắc chắn đã có rồi nên bỏ qua
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'client_id')) {
                $table->dropForeign(['client_id']);
                $table->dropColumn('client_id');
            }
        });
    }
};