<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BanReason;

class BanReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = [
            [
                'reason' => 'Violation of Code of Conduct',
                'description' => 'The lawyer has violated our professional code of conduct and ethics policy.'
            ],
            [
                'reason' => 'Substandard Profile/Credentials',
                'description' => 'The lawyer\'s profile does not meet our minimum professional standards and requirements.'
            ],
            [
                'reason' => 'Spam or Fraudulent Activity',
                'description' => 'The lawyer has engaged in spam activities or fraudulent behavior on the platform.'
            ],
            [
                'reason' => 'Unable to Verify Personal Information',
                'description' => 'We were unable to verify the lawyer\'s credentials and personal information provided.'
            ],
            [
                'reason' => 'Multiple Client Complaints',
                'description' => 'The lawyer has received multiple serious complaints from clients regarding unprofessional conduct.'
            ],
            [
                'reason' => 'Violation of Terms of Service',
                'description' => 'The lawyer has repeatedly violated our platform\'s terms of service.'
            ]
        ];

        foreach ($reasons as $reason) {
            BanReason::create($reason);
        }
    }
}
