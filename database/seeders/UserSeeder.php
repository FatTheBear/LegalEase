<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LawyerProfile;
use App\Models\CustomerProfile;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 🧑‍💼 Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // ⚖️ Luật sư
        $lawyer = User::create([
            'name' => 'Lawyer One',
            'email' => 'lawyer@example.com',
            'password' => Hash::make('123456'),
            'role' => 'lawyer',
        ]);

        LawyerProfile::create([
            'user_id' => $lawyer->id,
            'specialization' => 'Dân sự',
            'experience_years' => 5,
            'bio' => 'Luật sư chuyên về tư vấn dân sự và hợp đồng.',
        ]);

        // 👤 Khách hàng
        $customer = User::create([
            'name' => 'Customer One',
            'email' => 'customer@example.com',
            'password' => Hash::make('123456'),
            'role' => 'customer',
        ]);

        CustomerProfile::create([
            'user_id' => $customer->id,
            'phone' => '0909123456',
            'address' => 'Hà Nội, Việt Nam',
        ]);
    }
}
