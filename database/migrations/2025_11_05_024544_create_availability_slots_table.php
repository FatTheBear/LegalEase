<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lawyer_id')->constrained('users')->onDelete('cascade');
            
            $table->date('date');                    // ngày riêng
            $table->time('start_time');              // giờ bắt đầu
            $table->time('end_time');                // start + 2 tiếng

            $table->boolean('is_booked')->default(false);
            
            // Tạm thời để nullable + KHÔNG ràng buộc foreign key trước
            // Vì bảng appointments có thể chưa tồn tại hoặc cột id chưa đúng kiểu
            $table->unsignedBigInteger('appointment_id')->nullable();
            // $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');

            $table->timestamps();

            $table->unique(['lawyer_id', 'date', 'start_time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('availability_slots');
    }
};