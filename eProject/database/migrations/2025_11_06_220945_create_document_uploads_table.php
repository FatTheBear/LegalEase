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
        Schema::create('document_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết với bảng users
            $table->string('file_name'); // Tên file gốc
            $table->string('file_path'); // Đường dẫn lưu file
            $table->string('document_type'); // Loại tài liệu: 'degree', 'certificate', 'license', 'other'
            $table->string('file_extension'); // Phần mở rộng file: pdf, jpg, png...
            $table->bigInteger('file_size'); // Kích thước file (bytes)
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
        Schema::dropIfExists('document_uploads');
    }
};
