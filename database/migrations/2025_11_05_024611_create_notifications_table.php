<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người nhận
            $table->string('title');           // Tiêu đề thông báo
            $table->text('message');           // Nội dung
            $table->string('type');            // booking, rating, confirm, cancel...
            $table->boolean('is_read')->default(false);
            $table->json('data')->nullable();  // Lưu thêm dữ liệu nếu cần (link, id...)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};