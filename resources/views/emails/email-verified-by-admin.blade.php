<!DOCTYPE html>
<html>
<head>
    <title>Account Verified - Academia</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #667eea; margin-bottom: 10px;">🎉 Account Verified!</h1>
            <h2 style="color: #333;">Academia Platform</h2>
        </div>

        <div style="background: linear-gradient(135deg, #667eea, #764ba2); padding: 25px; border-radius: 10px; color: white; text-align: center; margin-bottom: 30px;">
            <h3 style="margin: 0; font-size: 24px;">✅ Verification Complete</h3>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">
                Your account has been approved by admin
            </p>
        </div>

        <div style="margin-bottom: 25px;">
            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            
            <p>We're pleased to inform you that your account has been <strong>successfully verified</strong> by our admin team.</p>
            
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0;"><strong>🔓 Account Status:</strong> <span style="color: #10b981;">VERIFIED & ACTIVE</span></p>
                <p style="margin: 5px 0 0 0;"><strong>👤 Verified By:</strong> {{ $admin->name }} (Admin)</p>
                <p style="margin: 5px 0 0 0;"><strong>📅 Verified On:</strong> {{ now()->format('F d, Y h:i A') }}</p>
            </div>
            
            <p>You can now login to your account and access all features.</p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" 
               style="display: inline-block; background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 14px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">
               🚀 Login to Your Account
            </a>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 20px; color: #666; font-size: 14px;">
            <p><strong>Login Details:</strong></p>
            <p>Email: <strong>{{ $user->email }}</strong></p>
            <p>You can use the password you set during registration.</p>
            
            <p style="margin-top: 20px;">
                If you face any issues, please contact support at 
                <a href="mailto:support@academia.com" style="color: #667eea;">support@academia.com</a>
            </p>
        </div>

        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #999; font-size: 12px;">
            <p>&copy; {{ date('Y') }} Academia. All rights reserved.</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>