<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #667eea;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .user-info p {
            margin: 10px 0;
            font-size: 16px;
        }
        .user-info strong {
            color: #667eea;
        }
        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 10px 5px;
        }
        .button:hover {
            background: #5568d3;
        }
        .button-secondary {
            background: #6c757d;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 New User Registration</h1>
            <p>Action Required: Verify New User</p>
        </div>
        
        <div class="content">
            <p>Hello Admin,</p>
            <p>A new user has registered on Academia GPA Tracker and requires your verification.</p>
            
            <div class="user-info">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Registered:</strong> {{ $user->created_at->format('F d, Y h:i A') }}</p>
            </div>
            
            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/admin/users/verify/' . $user->id) }}" class="button">
                    ✓ Verify User
                </a>
                <a href="{{ url('/admin/users') }}" class="button button-secondary">
                    View All Users
                </a>
            </p>
            
            <p style="color: #6c757d; font-size: 14px;">
                <strong>Note:</strong> Once verified, the user will receive an email notification and will be able to login.
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Academia GPA Tracker. All rights reserved.</p>
            <p>This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>