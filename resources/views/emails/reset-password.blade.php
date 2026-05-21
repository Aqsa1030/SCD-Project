<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        .reset-button {
            text-align: center;
            margin: 30px 0;
        }
        .reset-button a {
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
        .warning-box {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
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
            <div class="icon">🔐</div>
            <h1>🎓 ACADEMIA</h1>
            <p>Reset Your Password</p>
        </div>
        
        <div class="email-body">
            <div class="greeting">
                Hello {{ $userName }}! 👋
            </div>
            
            <div class="message">
                <p>We received a request to reset your password for your Academia account.</p>
                <p>Click the button below to create a new password:</p>
            </div>
            
            <div class="reset-button">
                <a href="{{ $link }}">
                    🔑 Reset Password
                </a>
            </div>
            
            <div class="alternative-link">
                <p><strong>Having trouble with the button?</strong></p>
                <p>Copy and paste this link into your browser:</p>
                <a href="{{ $link }}">{{ $link }}</a>
            </div>
            
            <div class="warning-box">
                <strong>⚠️ Security Notice:</strong>
                <ul style="margin: 10px 0 0 20px; padding: 0; color: #78350f;">
                    <li>This link will expire in 1 hour</li>
                    <li>If you didn't request a password reset, please ignore this email</li>
                    <li>Never share this link with anyone</li>
                </ul>
            </div>
        </div>
        
        <div class="email-footer">
            <p><strong>Academia GPA Tracker</strong></p>
            <p>© {{ date('Y') }} Academia. All rights reserved.</p>
        </div>
    </div>
</body>
</html>