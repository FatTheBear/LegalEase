<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved</title>
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
            margin: 10px 0 0 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .email-header .icon {
            font-size: 56px;
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
        .success-box {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-left: 5px solid #4caf50;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.15);
            text-align: center;
        }
        .success-box .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .success-box h2 {
            color: #2e7d32;
            font-size: 22px;
            margin: 10px 0;
            font-weight: 600;
        }
        .success-box p {
            margin: 5px 0 0 0;
            color: #388e3c;
            font-size: 15px;
        }
        .details-box {
            background-color: #fafafa;
            border: 2px solid #e6cfa7;
            padding: 25px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .details-box h3 {
            margin: 0 0 20px 0;
            color: #3a4b41;
            font-size: 18px;
            font-weight: 600;
            border-bottom: 2px solid #e6cfa7;
            padding-bottom: 10px;
        }
        .detail-row {
            display: flex;
            padding: 12px 15px;
            margin: 8px 0;
            background-color: #fff;
            border-radius: 6px;
            align-items: center;
        }
        .detail-label {
            font-weight: 600;
            color: #3a4b41;
            min-width: 140px;
        }
        .detail-value {
            color: #5a6b61;
            flex: 1;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }
        .next-steps {
            background-color: #f8f9fa;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
            border-left: 4px solid #3a4b41;
        }
        .next-steps h4 {
            margin: 0 0 15px 0;
            color: #3a4b41;
            font-size: 16px;
            font-weight: 600;
        }
        .next-steps ol {
            margin: 0;
            padding-left: 20px;
            color: #5a6b61;
        }
        .next-steps li {
            margin: 10px 0;
            font-size: 14px;
            line-height: 1.6;
        }
        .cta-box {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #e6cfa7 0%, #d4b896 100%);
            border-radius: 8px;
            text-align: center;
        }
        .cta-button {
            display: inline-block;
            padding: 14px 36px;
            background: linear-gradient(135deg, #3a4b41 0%, #2d3a33 100%);
            color: #e6cfa7;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 10px;
            box-shadow: 0 3px 8px rgba(58, 75, 65, 0.3);
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(58, 75, 65, 0.4);
        }
        .benefits-box {
            margin: 25px 0;
            padding: 20px;
            background-color: #fff9e6;
            border-radius: 8px;
            border: 1px solid #e6cfa7;
        }
        .benefits-box h4 {
            margin: 0 0 15px 0;
            color: #3a4b41;
            font-size: 16px;
            font-weight: 600;
        }
        .benefits-box ul {
            margin: 0;
            padding-left: 20px;
            color: #5a6b61;
        }
        .benefits-box li {
            margin: 8px 0;
            font-size: 14px;
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
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .detail-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="icon">✓</div>
            <h1>Account Approved!</h1>
        </div>
        
        <div class="email-body">
            <p class="greeting">Dear {{ $lawyer->name }},</p>
            
            <div class="success-box">
                <div class="icon">🎉</div>
                <h2>Congratulations!</h2>
                <p>Your lawyer account has been successfully approved</p>
            </div>
            
            <p style="color: #5a6b61; margin: 20px 0; font-size: 15px;">
                We are thrilled to welcome you to the LegalEase platform! After careful review of your credentials and qualifications, we are pleased to inform you that your lawyer account has been approved and is now active.
            </p>
            
            <div class="details-box">
                <h3>📋 Account Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Account Name:</span>
                    <span class="detail-value"><strong>{{ $lawyer->name }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $lawyer->email }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Specialization:</span>
                    <span class="detail-value">{{ $lawyer->profile->specialization ?? 'Not specified' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="status-badge">✓ Active</span>
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Approved Date:</span>
                    <span class="detail-value">{{ date('l, F d, Y') }}</span>
                </div>
            </div>
            
            <div class="next-steps">
                <h4>🚀 Next Steps to Get Started:</h4>
                <ol>
                    <li><strong>Complete Your Profile:</strong> Add more details about your experience, education, and practice areas to attract more clients</li>
                    <li><strong>Set Your Availability:</strong> Configure your schedule and available time slots for consultations</li>
                    <li><strong>Upload Professional Photo:</strong> Add a professional profile picture to build trust with potential clients</li>
                    <li><strong>Review Platform Guidelines:</strong> Familiarize yourself with our terms of service and best practices</li>
                    <li><strong>Start Receiving Bookings:</strong> Your profile is now live and visible to clients looking for legal services</li>
                </ol>
            </div>
            
            <div class="benefits-box">
                <h4>✨ What You Can Do Now:</h4>
                <ul>
                    <li>Access your personalized lawyer dashboard</li>
                    <li>Manage client appointments and consultations</li>
                    <li>Communicate with clients through our secure messaging system</li>
                    <li>Track your earnings and payment history</li>
                    <li>Build your reputation with client reviews and ratings</li>
                    <li>Grow your legal practice with our marketing tools</li>
                </ul>
            </div>
            
            <div class="cta-box">
                <h4 style="margin: 0 0 10px 0; color: #3a4b41;">Ready to Get Started?</h4>
                <p style="margin: 0 0 15px 0; color: #5a6b61; font-size: 14px;">Log in to your account and start connecting with clients today!</p>
                <a href="{{ url('/login') }}" class="cta-button">Access Your Dashboard →</a>
            </div>
            
            <div class="divider"></div>
            
            <p style="margin-top: 30px; color: #5a6b61; font-size: 14px; line-height: 1.8;">
                If you have any questions or need assistance getting started, our support team is here to help. Don't hesitate to reach out at <strong>support@legalease.com</strong> or call us at <strong>+1 (555) 123-4567</strong>.
            </p>
            
            <p style="color: #5a6b61; font-size: 14px; margin-top: 20px;">
                We're excited to have you as part of the LegalEase community and look forward to supporting your success on our platform!
            </p>
            
            <div class="signature">
                <p>Warmest regards,</p>
                <p><strong>LegalEase Administration Team</strong></p>
                <p style="font-size: 13px; color: #888;">Building the Future of Legal Services</p>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="logo">⚖️ LEGALEASE</div>
            <p>&copy; {{ date('Y') }} LegalEase. All rights reserved.</p>
            <p>Professional Legal Services Platform</p>
            <p style="margin-top: 15px; font-size: 12px; opacity: 0.8;">
                This email was sent to {{ $lawyer->email }}. You're receiving this because your lawyer account was approved.
            </p>
        </div>
    </div>
</body>
</html>
