<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kiểm tra xem admin đã tồn tại chưa
        if (!User::where('email', 'admin1')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin1',
                'password' => Hash::make('123'), 
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            echo "✅ Admin account created successfully!\n";
            echo "📧 Email: admin1\n";
            echo "🔑 Password: 123\n";
        } else {
            echo "⚠️ Admin account already exists!\n";
        }
    }
}

