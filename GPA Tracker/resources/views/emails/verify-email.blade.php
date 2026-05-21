<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 40px;
            text-align: center;
            color: white;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 900;
        }
        .email-header p {
            margin: 10px 0 0 0;
            opacity: 0.95;
            font-size: 16px;
        }
        .email-body {
            padding: 40px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .message {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .verify-button {
            text-align: center;
            margin: 30px 0;
        }
        .verify-button a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 16px 50px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }
        .alternative-link {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            border-left: 4px solid #667eea;
        }
        .alternative-link p {
            margin: 0 0 10px 0;
            color: #4a5568;
            font-size: 14px;
        }
        .alternative-link a {
            color: #667eea;
            word-break: break-all;
            font-size: 13px;
        }
        .email-footer {
            background: #f7fafc;
            padding: 30px;
            text-align: center;
            color: #718096;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="icon">📧</div>
            <h1>🎓 ACADEMIA</h1>
            <p>Verify Your Email Address</p>
        </div>
        
        <div class="email-body">
            <div class="greeting">
                Hello {{ $userName }}! 👋
            </div>
            
            <div class="message">
                <p>Thank you for registering with Academia GPA Tracker!</p>
                
                <p>To complete your registration and start tracking your academic progress, please verify your email address by clicking the button below:</p>
            </div>
            
            <div class="verify-button">
                <a href="{{ $link }}">
                    ✅ Verify Email Address
                </a>
            </div>
            
            <div class="alternative-link">
                <p><strong>Having trouble with the button?</strong></p>
                <p>Copy and paste this link into your browser:</p>
                <a href="{{ $link }}">{{ $link }}</a>
            </div>
            
            <div class="message" style="margin-top: 30px; color: #718096; font-size: 14px;">
                <p><strong>📌 Important:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>This link will expire in 24 hours</li>
                    <li>If you didn't create an account, please ignore this email</li>
                    <li>Never share this link with anyone</li>
                </ul>
            </div>
        </div>
        
        <div class="email-footer">
            <p><strong>Academia GPA Tracker</strong></p>
            <p>Your Academic Success Partner</p>
            <p style="margin-top: 15px; font-size: 12px;">
                © {{ date('Y') }} Academia. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>