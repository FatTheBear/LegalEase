<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LawyerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== SAMPLE LAWYER ACCOUNT (dễ nhớ để test) =====
        $sampleLawyer = User::create([
            'name' => 'Nguyễn Văn A - Sample Lawyer',
            'email' => 'sample.lawyer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'lawyer',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        LawyerProfile::create([
            'user_id' => $sampleLawyer->id,
            'specialization' => 'Luật Hành chính',
            'province' => 'Hà Nội',
            'experience' => 8,
            'license_number' => 'SAMPLE-001',
            'bio' => 'Luật sư mẫu để test',
            'approval_status' => 'approved',
        ]);

        // ===== OTHER VERIFIED LAWYERS =====
        $verifiedLawyers = [
            ['name' => 'John Smith', 'email' => 'john.smith@legalease.com', 'specialization' => 'Criminal Law', 'province' => 'New York'],
            ['name' => 'Sarah Johnson', 'email' => 'sarah.johnson@legalease.com', 'specialization' => 'Corporate Law', 'province' => 'California'],
            ['name' => 'Michael Brown', 'email' => 'michael.brown@legalease.com', 'specialization' => 'Family Law', 'province' => 'Illinois'],
            ['name' => 'Emily Davis', 'email' => 'emily.davis@legalease.com', 'specialization' => 'Intellectual Property', 'province' => 'California'],
            ['name' => 'David Wilson', 'email' => 'david.wilson@legalease.com', 'specialization' => 'Immigration Law', 'province' => 'Florida'],
            ['name' => 'Laura Martinez', 'email' => 'laura.martinez@legalease.com', 'specialization' => 'Tax Law', 'province' => 'Texas'],
            ['name' => 'James Anderson', 'email' => 'james.anderson@legalease.com', 'specialization' => 'Real Estate Law', 'province' => 'New York'],
            ['name' => 'Patricia Lee', 'email' => 'patricia.lee@legalease.com', 'specialization' => 'Employment Law', 'province' => 'California'],
            ['name' => 'Robert Taylor', 'email' => 'robert.taylor@legalease.com', 'specialization' => 'Intellectual Property', 'province' => 'Massachusetts'],
            ['name' => 'Linda Thomas', 'email' => 'linda.thomas@legalease.com', 'specialization' => 'Civil Litigation', 'province' => 'Florida'],
            ['name' => 'William Moore', 'email' => 'william.moore@legalease.com', 'specialization' => 'Criminal Defense', 'province' => 'Texas'],
            ['name' => 'Barbara Jackson', 'email' => 'barbara.jackson@legalease.com', 'specialization' => 'Family Law', 'province' => 'Illinois'],
            ['name' => 'Christopher White', 'email' => 'christopher.white@legalease.com', 'specialization' => 'Corporate Law', 'province' => 'New York'],
            ['name' => 'Elizabeth Harris', 'email' => 'elizabeth.harris@legalease.com', 'specialization' => 'Immigration Law', 'province' => 'California'],
            ['name' => 'Daniel Martin', 'email' => 'daniel.martin@legalease.com', 'specialization' => 'Contract Law', 'province' => 'Texas'],
        ];

        foreach ($verifiedLawyers as $lawyer) {
            $user = User::create([
                'name' => $lawyer['name'],
                'email' => $lawyer['email'],
                'password' => Hash::make('password123'),
                'role' => 'lawyer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            // Tạo profile luật sư
            LawyerProfile::create([
                'user_id' => $user->id,
                'specialization' => $lawyer['specialization'],
                'province' => $lawyer['province'],
                'experience' => rand(5, 20),
                'license_number' => 'LN-' . rand(1000, 9999),
                'bio' => 'Experienced lawyer in ' . $lawyer['specialization'],
                'approval_status' => 'approved',
            ]);
        }

        $pendingLawyers = [
            ['name' => 'Pending Lawyer 1', 'email' => 'pending1@legalease.com'],
            ['name' => 'Pending Lawyer 2', 'email' => 'pending2@legalease.com'],
            ['name' => 'Pending Lawyer 3', 'email' => 'pending3@legalease.com'],
            ['name' => 'Pending Lawyer 4', 'email' => 'pending4@legalease.com'],
            ['name' => 'Pending Lawyer 5', 'email' => 'pending5@legalease.com'],
        ];

        foreach ($pendingLawyers as $lawyer) {
            $user = User::create([
                'name' => $lawyer['name'],
                'email' => $lawyer['email'],
                'password' => Hash::make('password123'),
                'role' => 'lawyer',
                'status' => 'pending',
                'email_verified_at' => null,
            ]);

            LawyerProfile::create([
                'user_id' => $user->id,
                'specialization' => 'Unknown',
                'province' => 'Unknown',
                'experience' => 0,
                'license_number' => null,
                'bio' => null,
                'approval_status' => 'pending',
            ]);
        }

        echo "✅ 15 verified lawyers with profiles and 5 pending lawyers created successfully!\n";
        echo "\n🔐 SAMPLE LAWYER ACCOUNT FOR TESTING:\n";
        echo "Email: sample.lawyer@example.com\n";
        echo "Password: password123\n";
        echo "Status: Active ✅ (Approved)\n";
    }
}
