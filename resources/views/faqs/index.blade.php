@extends('layouts.app')
@section('title', 'Frequently Asked Questions')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">FAQ - Frequently Asked Questions</h2>

    <div class="mb-3 d-flex gap-2 flex-wrap">
        <input type="text" id="faqSearch" class="form-control" placeholder="Search questions...">
        <select id="faqCategory" class="form-select" style="max-width: 200px;">
            <option value="all">All Categories</option>
            <option value="login">Login / Logout</option>
            <option value="appointments">Appointments</option>
            <option value="lawyers">Lawyers</option>
            <option value="admin">Admin / Management</option>
        </select>
    </div>

    <div class="accordion" id="faqAccordion">
        @php
            $faqs = [
                ['id'=>1, 'question'=>'Is this website trustworthy for legal consultations?', 'answer'=>'Yes, LegalEase is a verified platform connecting you with licensed and vetted lawyers for consultations.', 'category'=>'lawyers'],
                ['id'=>2, 'question'=>'How do I register as a customer?', 'answer'=>'Click on the "Register" button in the navbar, choose Customer registration, fill in your details, and verify your email.', 'category'=>'login'],
                ['id'=>3, 'question'=>'How do I register as a lawyer?', 'answer'=>'Click on "Register" > "Lawyer", fill in your profile and credentials. Your application will be reviewed by an admin before approval.', 'category'=>'lawyers'],
                ['id'=>4, 'question'=>'How do I login and logout?', 'answer'=>'Use the "Login" button in the navbar to access your account. To logout, click your name > "Logout" in the dropdown menu.', 'category'=>'login'],
                ['id'=>5, 'question'=>'How can I manage my appointments?', 'answer'=>'Customers can view, create, confirm, or cancel appointments from their dashboard. Lawyers can manage their schedule and appointment requests.', 'category'=>'appointments'],
                ['id'=>6, 'question'=>'How are lawyers verified on this platform?', 'answer'=>'All lawyers must submit their credentials during registration. Admins review applications to ensure the lawyer is licensed and trustworthy.', 'category'=>'lawyers'],
                ['id'=>7, 'question'=>'How do I reset my password?', 'answer'=>'Click "Forgot Password" on the login page, enter your email, and follow the instructions to reset your password.', 'category'=>'login'],
                ['id'=>8, 'question'=>'How do I approve or reject a lawyer?', 'answer'=>'Admin can manage lawyer applications from the Admin Dashboard under the Lawyers section.', 'category'=>'admin'],
                ['id'=>9, 'question'=>'How do I cancel an appointment as a customer?', 'answer'=>'Go to your appointments dashboard, select the appointment, and click "Cancel".', 'category'=>'appointments'],
                ['id'=>10, 'question'=>'How can I edit my profile?', 'answer'=>'Click your name in the navbar > Profile > Edit to update your personal information.', 'category'=>'login'],
                ['id'=>11, 'question'=>'What should I do if my account is locked?', 'answer'=>'Contact platform support immediately via email or phone. We will verify your identity and unlock your account.', 'category'=>'login'],
                ['id'=>12, 'question'=>'Can I change my registered email address?', 'answer'=>'For security reasons, email changes require verification. Please contact support to initiate the process.', 'category'=>'login'],
                ['id'=>13, 'question'=>'Is two-factor authentication (2FA) available?', 'answer'=>'Currently, 2FA is under development. We recommend using a strong password for security.', 'category'=>'login'],
                ['id'=>14, 'question'=>'I didn\'t receive the email verification link, what should I do?', 'answer'=>'Check your spam or junk folder first. If not found, click the "Resend Verification Email" link on the login page.', 'category'=>'login'],
                ['id'=>15, 'question'=>'How long does a typical consultation last?', 'answer'=>'Standard consultations are scheduled for 30 minutes, but you can book longer sessions if offered by the lawyer.', 'category'=>'appointments'],
                ['id'=>16, 'question'=>'Can I reschedule a confirmed appointment?', 'answer'=>'Yes, rescheduling is possible, usually up to 24 hours before the original time. Go to your dashboard and look for the "Reschedule" option.', 'category'=>'appointments'],
                ['id'=>17, 'question'=>'What happens if the lawyer cancels the appointment?', 'answer'=>'You will be notified immediately. You will receive a full refund or the option to reschedule with the same lawyer or a different one.', 'category'=>'appointments'],
                ['id'=>18, 'question'=>'How do I join the consultation meeting?', 'answer'=>'The meeting link (e.g., Zoom/Google Meet) will be visible on the appointment details page 5 minutes before the scheduled time.', 'category'=>'appointments'],
                ['id'=>19, 'question'=>'How far in advance can I book an appointment?', 'answer'=>'Booking availability depends on the lawyer\'s schedule, typically up to 30 days in advance.', 'category'=>'appointments'],
                ['id'=>20, 'question'=>'Is there a cancellation fee?', 'answer'=>'Cancellations made less than 6 hours before the appointment may incur a small fee, depending on the lawyer\'s policy.', 'category'=>'appointments'],
                ['id'=>21, 'question'=>'How do I confirm an appointment as a lawyer?', 'answer'=>'Go to your dashboard, select the incoming request, and click the "Confirm" button. An email notification will be sent to the client.', 'category'=>'appointments'],
                ['id'=>22, 'question'=>'How can I search for a lawyer based on specialization?', 'answer'=>'Use the search bar and filter options on the "Find a Lawyer" page. You can filter by legal area (e.g., family law, corporate law).', 'category'=>'lawyers'],
                ['id'=>23, 'question'=>'Can I leave a review or rating for a lawyer?', 'answer'=>'Yes, after an appointment is marked as "Completed," a rating and review option will become available on your appointment dashboard.', 'category'=>'lawyers'],
                ['id'=>24, 'question'=>'What information is included in a lawyer\'s profile?', 'answer'=>'Profiles include their specialization, years of experience, success rate, client reviews, and available time slots.', 'category'=>'lawyers'],
                ['id'=>25, 'question'=>'How does the platform ensure lawyer quality?', 'answer'=>'Quality is maintained through strict credential verification, continuous performance monitoring, and mandatory client feedback/ratings.', 'category'=>'lawyers'],
                ['id'=>26, 'question'=>'How does a lawyer update their availability/schedule?', 'answer'=>'Lawyers manage their time slots directly through their Lawyer Dashboard under the "Schedule Management" section.', 'category'=>'lawyers'],
                ['id'=>27, 'question'=>'How do I manage the list of specializations?', 'answer'=>'Admins can add, edit, or remove specializations from the Admin Dashboard, typically under the "Settings" or "Categories" section.', 'category'=>'admin'],
                ['id'=>28, 'question'=>'How are platform disputes handled?', 'answer'=>'Admin reviews all disputes (e.g., payment issues, behavioral complaints) by investigating the evidence provided by both parties and making a final decision.', 'category'=>'admin'],
                ['id'=>29, 'question'=>'How can I generate a report on appointments?', 'answer'=>'The Admin Dashboard provides a "Reporting" section where you can filter and download data on appointments, users, and revenue.', 'category'=>'admin'],
                ['id'=>30, 'question'=>'Can I manually mark an appointment as "Completed"?', 'answer'=>'Yes, Admins have override privileges to manually change the status of any appointment from the Admin Dashboard for maintenance or correction purposes.', 'category'=>'admin'],
            ];
        @endphp

        @foreach($faqs as $faq)
        <div class="accordion-item" data-category="{{ $faq['category'] }}">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq['id'] }}">
                    {{ $faq['question'] }}
                </button>
            </h2>
            <div id="faq{{ $faq['id'] }}" class="accordion-collapse collapse">
                <div class="accordion-body">{{ $faq['answer'] }}</div>
            </div>
        </div>
        @endforeach
    </div>
    
    <hr class="my-5">

    {{-- PHẦN MỚI: NÚT VÀ MODAL LIÊN HỆ --}}
    <div class="text-center py-4">
        <h4 class="mb-3">Still have questions that are not answered above?</h4>
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#contactModal">
            <i class="bi bi-question-circle-fill me-2"></i> Need more help? Contact us!
        </button>
    </div>

</div>

<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header btn-primary text-white" ">
                <h5 class="modal-title" id="contactModalLabel">
                    <i class="bi bi-headset"></i> Contact Support
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="lead">If you cannot find the answer you need in our FAQ, please reach out to our support team.</p>

                <div class="list-group list-group-flush mb-4">
                    {{-- THÔNG TIN LIÊN HỆ CỦA BẠN (TỰ NHẬP BẰNG TIẾNG ANH) --}}
                    <a href="tel:+84123456789" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div><i class="bi me-3 text-primary"></i> Hotline Support</div>
                        <span class="fw-bold text-success">+84 123 456 789</span>
                    </a>
                    <a href="mailto:support@legalease.com" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div><i class="bi me-3 text-primary"></i> Email Support</div>
                        <span class="fw-bold text-secondary">support@legalease.com</span>
                    </a>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="bi me-3 text-primary"></i> Working Hours</div>
                        <span style="text-color: #35563c;">Mon - Fri, 8:00 AM - 5:00 PM (GMT+7)</span>
                    </div>
                </div>

                <small class="text-muted">For urgent legal matters, please contact local authorities immediately.</small>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearch');
    const categorySelect = document.getElementById('faqCategory');
    const faqItems = document.querySelectorAll('#faqAccordion .accordion-item');

    function filterFaqs() {
        const search = searchInput.value.toLowerCase();
        const category = categorySelect.value;

        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const itemCategory = item.getAttribute('data-category');
            const matchesSearch = question.includes(search);
            const matchesCategory = (category === 'all' || itemCategory === category);

            if (matchesSearch && matchesCategory) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterFaqs);
    categorySelect.addEventListener('change', filterFaqs);
});
</script>
@endsection