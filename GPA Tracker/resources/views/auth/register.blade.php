<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 20px;
        }
        
        .auth-container {
            max-width: 520px;
            width: 100%;
        }
        
        .auth-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .auth-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 50px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .auth-header .icon {
            font-size: 64px;
            margin-bottom: 16px;
            position: relative;
        }
        
        .auth-header h1 {
            margin: 0;
            font-size: 2.2rem;
            font-weight: 900;
            letter-spacing: 1px;
            position: relative;
        }
        
        .auth-header p {
            margin: 12px 0 0 0;
            opacity: 0.95;
            font-size: 15px;
            position: relative;
        }
        
        .auth-body {
            padding: 40px 35px;
        }
        
        .alert {
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 24px;
            border: none;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }
        
        .alert i {
            font-size: 20px;
            margin-top: 2px;
        }
        
        .alert-content strong {
            display: block;
            font-weight: 800;
            margin-bottom: 4px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
        }
        
        .form-label i {
            color: #667eea;
            font-size: 18px;
        }
        
        .form-control {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e9ecef;
            border-radius: 14px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8f9fa;
            font-weight: 500;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 5px rgba(102, 126, 234, 0.1);
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
            background: #fee2e2;
        }
        
        .form-control::placeholder {
            color: #9ca3af;
        }
        
        .invalid-feedback {
            color: #ef4444;
            font-size: 13px;
            font-weight: 600;
            margin-top: 8px;
            display: block;
        }
        
        .password-strength {
            margin-top: 8px;
            font-size: 13px;
        }
        
        .password-strength-bar {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }
        
        .password-strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
        }
        
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 18px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
        }
        
        .btn-register:active {
            transform: translateY(-1px);
        }
        
        .divider {
            text-align: center;
            margin: 28px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e9ecef;
        }
        
        .divider span {
            background: white;
            padding: 0 20px;
            position: relative;
            color: #6c757d;
            font-size: 14px;
            font-weight: 600;
        }
        
        .login-link {
            text-align: center;
            margin-top: 24px;
        }
        
        .login-link p {
            margin: 0;
            color: #4a5568;
            font-size: 15px;
        }
        
        .login-link a {
            color: #667eea;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 32px;
        }
        
        .footer-text p {
            color: white;
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            body {
                padding: 30px 15px;
            }
            
            .auth-header {
                padding: 40px 20px;
            }
            
            .auth-header h1 {
                font-size: 1.8rem;
            }
            
            .auth-header .icon {
                font-size: 48px;
            }
            
            .auth-body {
                padding: 30px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1>ACADEMIA</h1>
                <p>Create your account to get started</p>
            </div>
            
            <div class="auth-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div class="alert-content">
                        <strong>Oops! Please fix the following errors:</strong>
                        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            <span>Full Name</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="John Doe"
                               value="{{ old('name') }}"
                               required
                               autofocus>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i>
                            <span>Email Address</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="your.email@example.com"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i>
                            <span>Password</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Minimum 6 characters"
                               required>
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i>
                            <span>Confirm Password</span>
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               class="form-control" 
                               placeholder="Re-enter your password"
                               required>
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i>
                        <span>Create Account</span>
                    </button>
                </form>

                <div class="divider">
                    <span>OR</span>
                </div>

                <div class="login-link">
                    <p>Already have an account? 
                        <a href="{{ route('login') }}">Login here</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="footer-text">
            <p>&copy; {{ date('Y') }} Academia. All rights reserved.</p>
        </div>
    </div>
</body>
</html>