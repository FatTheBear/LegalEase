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
        // ⚖️ Luật sư
        $lawyer = User::firstOrCreate(
            ['email' => 'lawyer@example.com'],
            [
                'name' => 'Lawyer One',
                'password' => Hash::make('123456'),
                'role' => 'lawyer',
                'status' => 'active',
            ]
        );

        LawyerProfile::firstOrCreate(
            ['user_id' => $lawyer->id],
            [
                'specialization' => 'Dân sự',
                'experience' => 5,
                'bio' => 'Luật sư chuyên về tư vấn dân sự và hợp đồng.',
            ]
        );

        // 👤 Khách hàng
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer One',
                'password' => Hash::make('123456'),
                'role' => 'customer',
                'status' => 'active',
            ]
        );

        CustomerProfile::firstOrCreate(
            ['user_id' => $customer->id],
            [
                'phone' => '0909123456',
                'address' => 'Hà Nội, Việt Nam',
            ]
        );
    }
}
