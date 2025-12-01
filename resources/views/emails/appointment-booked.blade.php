<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .header {
            background-color: #3a4b41;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            color: #3a4b41;
            font-size: 18px;
            border-bottom: 2px solid #E6CFA7;
            padding-bottom: 10px;
        }
        .appointment-details {
            background-color: #E6CFA7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .detail-row {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }
        .label {
            font-weight: bold;
            color: #3a4b41;
            min-width: 150px;
        }
        .lawyer-info {
            background-color: #f0f0f0;
            padding: 15px;
            border-left: 4px solid #3a4b41;
            margin: 15px 0;
        }
        .lawyer-info h3 {
            margin: 0 0 10px 0;
            color: #3a4b41;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            background-color: #3a4b41;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
        }
        .button:hover {
            background-color: #2d3d33;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✓ Appointment Booking Confirmed</h1>
            <p>Your appointment has been successfully booked with LegalEase</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>Dear {{ $client->name }},</h2>
                <p>Thank you for booking an appointment through LegalEase! Your booking request has been received successfully.</p>
            </div>

            <div class="section">
                <h2>Appointment Details</h2>
                <div class="appointment-details">
                    <div class="detail-row">
                        <span class="label">Date:</span>
                        <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('l, F d, Y') }}</strong>
                    </div>
                    <div class="detail-row">
                        <span class="label">Time:</span>
                        <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</strong>
                    </div>
                    <div class="detail-row">
                        <span class="label">Status:</span>
                        <strong><span style="color: #ff9800; font-weight: bold;">Pending Lawyer Confirmation</span></strong>
                    </div>
                    <div class="detail-row">
                        <span class="label">Booking ID:</span>
                        <strong>#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</strong>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Your Lawyer</h2>
                <div class="lawyer-info">
                    <h3>{{ $lawyer->name }}</h3>
                    <p>
                        <strong>Specialization:</strong> 
                        {{ $lawyer->lawyerProfile->specialization ?? 'General Legal Services' }}
                    </p>
                    <p>
                        <strong>Location:</strong> 
                        {{ $lawyer->lawyerProfile->province ?? 'Not specified' }}
                    </p>
                    @if($lawyer->lawyerProfile->experience)
                    <p>
                        <strong>Experience:</strong> 
                        {{ $lawyer->lawyerProfile->experience }} years
                    </p>
                    @endif
                    <p>
                        <strong>Email:</strong> 
                        <a href="mailto:{{ $lawyer->email }}">{{ $lawyer->email }}</a>
                    </p>
                </div>
            </div>

            <div class="section">
                <h2>What's Next?</h2>
                <p>Your appointment request has been sent to the lawyer. They will review and confirm your booking shortly. You'll receive an email notification once they confirm.</p>
                <p><strong>Note:</strong> Please keep your booking ID ({{ '#' . str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}) for your records.</p>
            </div>

            @if($appointment->notes)
            <div class="section">
                <h2>Your Notes</h2>
                <p>{{ $appointment->notes }}</p>
            </div>
            @endif

            <div class="section">
                <p style="text-align: center;">
                    <a href="{{ route('appointments.index') }}" class="button">View Your Appointments</a>
                </p>
            </div>

            <div class="section">
                <h2>Questions?</h2>
                <p>If you have any questions about your booking, please don't hesitate to:</p>
                <ul>
                    <li>Contact the lawyer directly at {{ $lawyer->email }}</li>
                    <li>Email our support team at support@legalease.com</li>
                    <li>Visit our <a href="{{ url('/') }}">website</a> for more information</li>
                </ul>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} LegalEase. All rights reserved.</p>
                <p>This is an automated email. Please do not reply directly to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>
