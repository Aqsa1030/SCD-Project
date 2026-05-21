<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia - Student GPA Tracker</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
        .feature-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .btn-hero {
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 50px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap"></i> Academia
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white mx-2" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('features') }}">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary mx-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white mx-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Sign Up
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">Track Your Academic Journey</h1>
                    <p class="lead mb-4">
                        Academia helps you monitor your GPA, manage courses, track attendance, 
                        and achieve your academic goals with ease.
                    </p>
                    <div class="d-flex gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-hero">
                                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-hero">
                                <i class="fas fa-user-plus"></i> Get Started 
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-hero">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-graduation-cap" style="font-size: 250px; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Why Choose Academia?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-calculator text-primary" style="font-size: 50px;"></i>
                        </div>
                        <h4>GPA Calculator</h4>
                        <p class="text-muted">Calculate your semester and cumulative GPA automatically with precision.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-calendar-check text-success" style="font-size: 50px;"></i>
                        </div>
                        <h4>Attendance Tracking</h4>
                        <p class="text-muted">Monitor your class attendance and get alerts for low attendance.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-tasks text-warning" style="font-size: 50px;"></i>
                        </div>
                        <h4>Task Management</h4>
                        <p class="text-muted">Keep track of assignments, projects, and deadlines effortlessly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-chart-line text-info" style="font-size: 50px;"></i>
                        </div>
                        <h4>Grade Tracking</h4>
                        <p class="text-muted">Record and analyze your grades across all courses and semesters.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-file-pdf text-danger" style="font-size: 50px;"></i>
                        </div>
                        <h4>Generate Reports</h4>
                        <p class="text-muted">Create and export professional transcripts and progress reports.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-mobile-alt text-purple" style="font-size: 50px; color: #764ba2;"></i>
                        </div>
                        <h4>Responsive Design</h4>
                        <p class="text-muted">Access your data anywhere, anytime on any device.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Ready to Take Control of Your Academics?</h2>
            <p class="lead mb-4">Join thousands of students managing their academic success with Academia</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-hero">
                    <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-hero">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
            @endauth
        </div>
    </section>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>