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
        .reset-details {
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
        .security-info {
            background-color: #f0f0f0;
            padding: 15px;
            border-left: 4px solid #3a4b41;
            margin: 15px 0;
        }
        .security-info h3 {
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
            <h1>✓ Password Reset Request</h1>
            <p>Your password reset link has been sent to your email</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>Dear {{ $user->name }},</h2>
                <p>You requested to reset your password because you forgot your current password. Please use the link below to set a new password.</p>
            </div>

            <div class="section">
                <h2>Reset Link Details</h2>
                <div class="reset-details">
                    <div class="detail-row">
                        <span class="label">Expires In:</span>
                        <strong><span style="color: #ff9800; font-weight: bold;">60 Minutes</span></strong>
                    </div>
                    <div class="detail-row">
                        <span class="label">Status:</span>
                        <strong>Active</strong>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Reset Your Password</h2>
                <p>Click the button below to set a new password. This link will expire in 60 minutes.</p>
                <p style="text-align: center;">
                    <a href="{{ $resetUrl }}" class="button">Reset Password</a>
                </p>
                <p style="font-size: 12px; color: #666; text-align: center; margin-top: 10px;">
                    Or copy and paste this link into your browser:<br>
                    <a href="{{ $resetUrl }}" style="color: #3a4b41; word-break: break-all; font-size: 11px;">{{ $resetUrl }}</a>
                </p>
            </div>

            <div class="section">
                <h2>Security Information</h2>
                <div class="security-info">
                    <h3>Important Security Notice</h3>
                    <ul style="margin: 10px 0; padding-left: 20px;">
                        <li>This link will expire in 60 minutes</li>
                        <li>If you did not request a password reset, please ignore this email</li>
                        <li>For security reasons, please do not share this link with anyone</li>
                        <li>Your password will not be changed until you click the link above and create a new one</li>
                    </ul>
                </div>
            </div>

            <div class="section">
                <h2>Questions?</h2>
                <p>If you have any questions about this password reset request, please don't hesitate to:</p>
                <ul>
                    <li>Email our support team at support@legalease.com</li>
                    <li>Visit our <a href="{{ url('/') }}" style="color: #3a4b41;">website</a> for more information</li>
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

