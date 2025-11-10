<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chạy migration.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable(); // Xác thực email cho customer
            $table->string('password', 255);
            $table->enum('role', ['admin', 'lawyer', 'customer'])->default('customer');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->nullable(); // Duyệt lawyer
            $table->rememberToken(); // dùng cho tính năng "remember me"
            $table->timestamps();
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
