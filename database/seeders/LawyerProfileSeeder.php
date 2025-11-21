<?php

namespace Database\Seeders;

use App\Models\LawyerProfile;
use Illuminate\Database\Seeder;

class LawyerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            ['user_id' => 1, 'specialization' => 'Criminal Law', 'experience' => 12, 'license_number' => 'CL-2025-001', 'city' => 'New York', 'province' => 'NY', 'approval_status' => 'approved', 'rating' => 4.8, 'bio' => 'Experienced criminal defense attorney with over 12 years of practice. Specialized in white-collar crimes and drug offenses.'],
            ['user_id' => 2, 'specialization' => 'Corporate Law', 'experience' => 15, 'license_number' => 'CL-2025-002', 'city' => 'Los Angeles', 'province' => 'CA', 'approval_status' => 'approved', 'rating' => 4.9, 'bio' => 'Senior corporate lawyer specializing in M&A, contract negotiations, and business formation. Fortune 500 experience.'],
            ['user_id' => 3, 'specialization' => 'Family Law', 'experience' => 10, 'license_number' => 'FL-2025-001', 'city' => 'Chicago', 'province' => 'IL', 'approval_status' => 'approved', 'rating' => 4.7, 'bio' => 'Compassionate family law attorney handling divorces, custody battles, and prenuptial agreements.'],
            ['user_id' => 4, 'specialization' => 'Intellectual Property', 'experience' => 8, 'license_number' => 'IP-2025-001', 'city' => 'San Francisco', 'province' => 'CA', 'approval_status' => 'approved', 'rating' => 4.9, 'bio' => 'IP specialist with expertise in patents, trademarks, copyrights, and tech litigation. Tech industry veteran.'],
            ['user_id' => 5, 'specialization' => 'Immigration Law', 'experience' => 11, 'license_number' => 'IL-2025-001', 'city' => 'Miami', 'province' => 'FL', 'approval_status' => 'approved', 'rating' => 4.8, 'bio' => 'Immigration attorney specializing in visa sponsorships, deportation defense, and citizenship applications.'],

            ['user_id' => 6, 'specialization' => 'Tax Law', 'experience' => 9, 'license_number' => 'TX-2025-001', 'city' => 'Houston', 'province' => 'TX', 'approval_status' => 'approved', 'rating' => 4.6, 'bio' => 'Expert in tax planning and dispute resolution.'],
            ['user_id' => 7, 'specialization' => 'Real Estate Law', 'experience' => 7, 'license_number' => 'RE-2025-001', 'city' => 'Dallas', 'province' => 'TX', 'approval_status' => 'approved', 'rating' => 4.5, 'bio' => 'Focused on property transactions and disputes.'],
            ['user_id' => 8, 'specialization' => 'Employment Law', 'experience' => 14, 'license_number' => 'EM-2025-001', 'city' => 'Seattle', 'province' => 'WA', 'approval_status' => 'approved', 'rating' => 4.7, 'bio' => 'Experienced in labor disputes and employment contracts.'],
            ['user_id' => 9, 'specialization' => 'Intellectual Property', 'experience' => 6, 'license_number' => 'IP-2025-002', 'city' => 'Boston', 'province' => 'MA', 'approval_status' => 'approved', 'rating' => 4.6, 'bio' => 'Patent and trademark law specialist.'],
            ['user_id' => 10, 'specialization' => 'Civil Litigation', 'experience' => 13, 'license_number' => 'CL-2025-003', 'city' => 'Philadelphia', 'province' => 'PA', 'approval_status' => 'approved', 'rating' => 4.8, 'bio' => 'Litigator handling civil cases and disputes.'],

            ['user_id' => 11, 'specialization' => 'Criminal Defense', 'experience' => 10, 'license_number' => 'CD-2025-001', 'city' => 'San Diego', 'province' => 'CA', 'approval_status' => 'approved', 'rating' => 4.7, 'bio' => 'Defense attorney for criminal cases.'],
            ['user_id' => 12, 'specialization' => 'Family Law', 'experience' => 9, 'license_number' => 'FL-2025-002', 'city' => 'Austin', 'province' => 'TX', 'approval_status' => 'approved', 'rating' => 4.6, 'bio' => 'Handling divorce and custody matters.'],
            ['user_id' => 13, 'specialization' => 'Corporate Law', 'experience' => 12, 'license_number' => 'CL-2025-004', 'city' => 'San Jose', 'province' => 'CA', 'approval_status' => 'approved', 'rating' => 4.9, 'bio' => 'Corporate contracts and M&A specialist.'],
            ['user_id' => 14, 'specialization' => 'Immigration Law', 'experience' => 11, 'license_number' => 'IL-2025-002', 'city' => 'Orlando', 'province' => 'FL', 'approval_status' => 'approved', 'rating' => 4.8, 'bio' => 'Visa and citizenship applications expert.'],
            ['user_id' => 15, 'specialization' => 'Contract Law', 'experience' => 10, 'license_number' => 'CT-2025-001', 'city' => 'Denver', 'province' => 'CO', 'approval_status' => 'approved', 'rating' => 4.7, 'bio' => 'Specialist in drafting and reviewing contracts.'],
        ];

        foreach ($profiles as $profile) {
            LawyerProfile::create($profile);
        }

        echo "✅ 15 verified lawyer profiles created successfully!\n";
        echo "✅ Pending lawyers do not have profiles yet.\n";
    }
}
