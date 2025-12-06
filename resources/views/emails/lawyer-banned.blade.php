<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspension Notice</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 650px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(58, 75, 65, 0.15);
        }
        .email-header {
            background: linear-gradient(135deg, #3a4b41 0%, #2d3a33 100%);
            color: #e6cfa7;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .email-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #e6cfa7 0%, #d4b896 100%);
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .email-header .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .email-body {
            padding: 40px 35px;
            background-color: #ffffff;
        }
        .greeting {
            font-size: 18px;
            color: #3a4b41;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .warning-box {
            background: linear-gradient(135deg, #fff9e6 0%, #fff3d4 100%);
            border-left: 5px solid #e6cfa7;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(230, 207, 167, 0.2);
        }
        .warning-box strong {
            color: #3a4b41;
            font-size: 16px;
            display: block;
            margin-bottom: 8px;
        }
        .warning-box p {
            margin: 0;
            color: #5a6b61;
            font-size: 14px;
        }
        .reason-box {
            background-color: #fafafa;
            border: 2px solid #e6cfa7;
            padding: 25px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .reason-box h3 {
            margin: 0 0 15px 0;
            color: #3a4b41;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .reason-box h3::before {
            content: '⚠️';
            margin-right: 10px;
            font-size: 22px;
        }
        .reason-box p {
            margin: 0;
            color: #dc3545;
            font-size: 16px;
            font-weight: 600;
            padding: 15px;
            background-color: #fff;
            border-radius: 6px;
            border-left: 4px solid #dc3545;
        }
        .info-section {
            background-color: #f8f9fa;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
            border-left: 4px solid #3a4b41;
        }
        .info-section h4 {
            margin: 0 0 15px 0;
            color: #3a4b41;
            font-size: 16px;
            font-weight: 600;
        }
        .info-section ul {
            margin: 0;
            padding-left: 20px;
            color: #5a6b61;
        }
        .info-section li {
            margin: 8px 0;
            font-size: 14px;
        }
        .contact-box {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #e6cfa7 0%, #d4b896 100%);
            border-radius: 8px;
            text-align: center;
        }
        .contact-box h4 {
            margin: 0 0 15px 0;
            color: #3a4b41;
            font-size: 18px;
            font-weight: 600;
        }
        .contact-box p {
            margin: 8px 0;
            color: #3a4b41;
            font-size: 14px;
        }
        .contact-box strong {
            color: #2d3a33;
        }
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, #e6cfa7 50%, transparent 100%);
            margin: 30px 0;
        }
        .signature {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e6cfa7;
        }
        .signature p {
            margin: 5px 0;
            color: #5a6b61;
        }
        .signature strong {
            color: #3a4b41;
            font-size: 16px;
        }
        .email-footer {
            background: linear-gradient(135deg, #3a4b41 0%, #2d3a33 100%);
            padding: 25px 30px;
            text-align: center;
            color: #e6cfa7;
        }
        .email-footer p {
            margin: 8px 0;
            font-size: 13px;
        }
        .email-footer .logo {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 20px 10px;
            }
            .email-header, .email-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="icon">🔒</div>
            <h1>Account Suspension Notice</h1>
        </div>
        
        <div class="email-body">
            <p class="greeting">Dear {{ $lawyer->name }},</p>
            
            <div class="warning-box">
                <strong>⚠️ Important Notice</strong>
                <p>Your LegalEase lawyer account has been suspended by our administration team.</p>
            </div>
            
            <p style="color: #5a6b61; margin: 20px 0;">We regret to inform you that after careful review, we have made the decision to suspend your account on the LegalEase platform.</p>
            
            <div class="reason-box">
                <h3>Reason for Suspension</h3>
                <p>{{ $reason->reason }}</p>
            </div>
            
            <div class="info-section">
                <h4>What This Means:</h4>
                <ul>
                    <li>You will no longer have access to your lawyer account</li>
                    <li>Your profile is hidden from all clients</li>
                    <li>All pending appointments have been automatically cancelled</li>
                    <li>Your account information remains in our system for administrative purposes</li>
                </ul>
            </div>
            
            <div class="divider"></div>
            
            <div class="contact-box">
                <h4>📞 Need to Discuss This Decision?</h4>
                <p>If you believe this suspension was made in error or would like to appeal this decision, please don't hesitate to contact our support team:</p>
                <p><strong>📧 Email:</strong> support@legalease.com</p>
                <p><strong>📞 Phone:</strong> +1 (555) 123-4567</p>
                <p><strong>⏰ Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM EST</p>
            </div>
            
            <p style="margin-top: 30px; color: #5a6b61; font-size: 14px; line-height: 1.8;">
                We take the quality, integrity, and professionalism of our platform very seriously. All decisions are made in accordance with our Terms of Service and Community Guidelines to ensure the best experience for our clients and legal professionals.
            </p>
            
            <div class="signature">
                <p>Sincerely,</p>
                <p><strong>LegalEase Administration Team</strong></p>
                <p style="font-size: 13px; color: #888;">Committed to Excellence in Legal Services</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="logo">⚖️ LEGALEASE</div>
            <p>&copy; {{ date('Y') }} LegalEase. All rights reserved.</p>
            <p>Professional Legal Services Platform</p>
            <p style="margin-top: 15px; font-size: 12px; opacity: 0.8;">This is an automated notification. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
