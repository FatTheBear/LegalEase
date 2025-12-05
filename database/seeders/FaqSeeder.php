<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Is this website trustworthy for legal consultations?',
                'answer' => 'Yes, LegalEase is a verified platform connecting you with licensed and vetted lawyers for consultations. All lawyers on our platform undergo thorough background checks and provide verified credentials. We maintain strict confidentiality standards and comply with all legal and data protection regulations. Your consultations are secure and protected by attorney-client privilege.',
            ],
            [
                'question' => 'How do I register as a customer?',
                'answer' => 'To register as a customer, click the "Sign Up as Customer" button on the homepage. Fill in your personal information including your name, email, and create a strong password. You\'ll receive a verification email - click the link to verify your account. After verification, you can immediately start browsing lawyers and booking consultations. The entire process takes just a few minutes.',
            ],
            [
                'question' => 'What information do I need to become a lawyer on LegalEase?',
                'answer' => 'To register as a lawyer, you need to provide: your full name, professional email, valid license number, years of experience, current workplace, and your specialization (e.g., Criminal Law, Corporate Law). You\'ll also need to upload proof of credentials such as your law degree, bar admission certificate, and any professional licenses. Our admin team reviews all applications within 2-3 business days.',
            ],
            [
                'question' => 'How do I book an appointment with a lawyer?',
                'answer' => 'Browse our directory of available lawyers, filter by specialization or location, and select a lawyer. View their available time slots and select one that suits your schedule. Add any additional notes about your case. Once booked, you\'ll receive a confirmation email with all appointment details. The lawyer will review and confirm your booking, after which you\'ll receive another confirmation.',
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'Currently, LegalEase supports multiple payment methods for your convenience. You can pay through credit cards, debit cards, and digital wallets. All transactions are processed through secure payment gateways with end-to-end encryption. Payment is typically collected before or after the consultation, depending on the lawyer\'s policy. We provide detailed invoices for all transactions.',
            ],
            [
                'question' => 'Can I reschedule or cancel my appointment?',
                'answer' => 'Yes, you can reschedule or cancel your appointment up to 24 hours before the scheduled time without any penalty. To cancel or reschedule, go to your appointments dashboard, select the appointment, and choose your preferred option. If you cancel within 24 hours, a cancellation fee may apply as per the lawyer\'s policy. The lawyer will receive a notification of any changes.',
            ],
            [
                'question' => 'Are consultations confidential?',
                'answer' => 'Absolutely. All consultations on LegalEase are strictly confidential and protected by attorney-client privilege. Our platform uses encrypted communication channels to ensure your privacy. Lawyers are bound by professional ethics to maintain confidentiality. We do not share your personal information or consultation details with third parties without your explicit consent, except as required by law.',
            ],
            [
                'question' => 'How long does a typical consultation take?',
                'answer' => 'Consultation duration varies depending on the complexity of your case and the lawyer\'s availability. Most consultations range from 30 minutes to 1 hour. During booking, you can see the available time slots offered by each lawyer. You can discuss the expected duration directly with the lawyer during the consultation or via email before the appointment.',
            ],
            [
                'question' => 'What if I\'m not satisfied with the consultation?',
                'answer' => 'If you\'re unsatisfied with your consultation, you can leave feedback and provide a detailed review on the lawyer\'s profile. You can also contact our support team to file a complaint. We encourage open communication and will work with both you and the lawyer to resolve any issues. For serious concerns, we have a formal dispute resolution process to ensure fair treatment.',
            ],
            [
                'question' => 'How can I contact customer support?',
                'answer' => 'You can reach our customer support team through multiple channels: email us at support@legalease.com, use the contact form on our website, or call our support hotline during business hours (9 AM - 6 PM, Monday to Friday). We typically respond to inquiries within 24 hours. For urgent matters, use the live chat feature available on our website.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
