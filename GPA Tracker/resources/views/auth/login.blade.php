<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Academia</title>
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
            padding: 20px;
        }
        
        .auth-container {
            max-width: 480px;
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
        
        .alert i {
            font-size: 20px;
            margin-top: 2px;
        }
        
        .alert-content {
            flex: 1;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border-left: 5px solid #10b981;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border-left: 5px solid #ef4444;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border-left: 5px solid #f59e0b;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border-left: 5px solid #3b82f6;
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
        
        .form-control::placeholder {
            color: #9ca3af;
        }
        
        .form-check {
            margin-bottom: 24px;
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 0;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .form-check-label {
            margin-left: 10px;
            font-weight: 600;
            color: #4a5568;
            cursor: pointer;
        }
        
        .btn-login {
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
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:active {
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
        
        .links-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .auth-link {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .auth-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .register-link p {
            margin: 0;
            color: #4a5568;
            font-size: 15px;
        }
        
        .register-link a {
            color: #667eea;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .register-link a:hover {
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
        
        @media (max-width: 576px) {
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
            
            .links-container {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>ACADEMIA</h1>
                <p>Welcome back! Please login to your account</p>
            </div>
            
            <div class="auth-body">
             
                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div class="alert-content">
                        <strong>Success!</strong>
                        <p class="mb-0 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <!-- 🔵 INFO Messages -->
                @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <div class="alert-content">
                        <strong>Info</strong>
                        <p class="mb-0 mt-1">{{ session('info') }}</p>
                    </div>
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="alert-content">
                        <strong>Warning</strong>
                        <p class="mb-0 mt-1">{{ session('warning') }}</p>
                    </div>
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div class="alert-content">
                        <strong>Error!</strong>
                        <div class="mt-1">
                            @foreach($errors->all() as $error)
                                <div class="mb-1">{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i>
                            <span>Email Address</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               placeholder="your.email@example.com"
                               value="{{ old('email') }}"
                               required
                               autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i>
                            <span>Password</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="Enter your password"
                               required>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="remember" 
                               id="remember">
                        <label class="form-check-label" for="remember">
                            Remember me for 30 days
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login to Academia</span>
                    </button>

                    <div class="links-container">
                        <a href="{{ route('password.request') }}" class="auth-link">
                            <i class="fas fa-key"></i>
                            Forgot Password?
                        </a>
                        
                        
                    </div>
                </form>

                <div class="divider">
                    <span>OR</span>
                </div>

                <div class="register-link">
                    <p>Don't have an account? 
                        <a href="{{ route('register') }}">Register now</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="footer-text">
            <p>&copy; {{ date('Y') }} Academia. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>