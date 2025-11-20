<?php

namespace Database\Seeders;

use App\Models\LawyerProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LawyerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
            [
                'user_id' => 1, // John Smith
                'specialization' => 'Criminal Law',
                'experience' => 12,
                'license_number' => 'CL-2025-001',
                'city' => 'New York',
                'province' => 'NY',
                'approval_status' => 'approved',
                'rating' => 4.8,
                'bio' => 'Experienced criminal defense attorney with over 12 years of practice. Specialized in white-collar crimes and drug offenses.',
            ],
            [
                'user_id' => 2, // Sarah Johnson
                'specialization' => 'Corporate Law',
                'experience' => 15,
                'license_number' => 'CL-2025-002',
                'city' => 'Los Angeles',
                'province' => 'CA',
                'approval_status' => 'approved',
                'rating' => 4.9,
                'bio' => 'Senior corporate lawyer specializing in M&A, contract negotiations, and business formation. Fortune 500 experience.',
            ],
            [
                'user_id' => 3, // Michael Brown
                'specialization' => 'Family Law',
                'experience' => 10,
                'license_number' => 'FL-2025-001',
                'city' => 'Chicago',
                'province' => 'IL',
                'approval_status' => 'approved',
                'rating' => 4.7,
                'bio' => 'Compassionate family law attorney handling divorces, custody battles, and prenuptial agreements.',
            ],
            [
                'user_id' => 4, // Emily Davis
                'specialization' => 'Intellectual Property',
                'experience' => 8,
                'license_number' => 'IP-2025-001',
                'city' => 'San Francisco',
                'province' => 'CA',
                'approval_status' => 'approved',
                'rating' => 4.9,
                'bio' => 'IP specialist with expertise in patents, trademarks, copyrights, and tech litigation. Tech industry veteran.',
            ],
            [
                'user_id' => 5, // David Wilson
                'specialization' => 'Immigration Law',
                'experience' => 11,
                'license_number' => 'IL-2025-001',
                'city' => 'Miami',
                'province' => 'FL',
                'approval_status' => 'approved',
                'rating' => 4.8,
                'bio' => 'Immigration attorney specializing in visa sponsorships, deportation defense, and citizenship applications.',
            ],
        ];

        foreach ($profiles as $profile) {
            LawyerProfile::create($profile);
        }

        echo "✅ 5 Lawyer profiles created successfully!\n";
    }
}
