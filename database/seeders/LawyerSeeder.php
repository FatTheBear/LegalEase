<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lawyers = [
            [
                'name' => 'John Smith - Criminal Law Specialist',
                'email' => 'john.smith@legalease.com',
                'password' => Hash::make('password123'),
                'role' => 'lawyer',
                'status' => 'active',
                // 'approval_status' => 'approved',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson - Corporate Lawyer',
                'email' => 'sarah.johnson@legalease.com',
                'password' => Hash::make('password123'),
                'role' => 'lawyer',
                'status' => 'active',
                // 'approval_status' => 'approved',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Michael Brown - Family Law Expert',
                'email' => 'michael.brown@legalease.com',
                'password' => Hash::make('password123'),
                'role' => 'lawyer',
                'status' => 'active',
                // 'approval_status' => 'approved',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Emily Davis - Intellectual Property',
                'email' => 'emily.davis@legalease.com',
                'password' => Hash::make('password123'),
                'role' => 'lawyer',
                'status' => 'active',
                // 'approval_status' => 'approved',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Wilson - Immigration Attorney',
                'email' => 'david.wilson@legalease.com',
                'password' => Hash::make('password123'),
                'role' => 'lawyer',
                'status' => 'active',
                // 'approval_status' => 'approved',
                'email_verified_at' => now(),
            ],
        ];


        foreach ($lawyers as $lawyer) {
            User::create($lawyer);
        }
         User::create([
    'name' => 'Lawyer Pending',
    'email' => 'lawyer.pending@example.com',
    'password' => bcrypt('123456'), // Dùng bcrypt()
    'role' => 'lawyer',
    'status' => 'active',
]);
        echo "✅ 5 Sample lawyers created successfully!\n";
    }
   
}
