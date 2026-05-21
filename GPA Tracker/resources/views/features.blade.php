<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - Academia GPA Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
        }
        
        .page-header p {
            font-size: 1.3rem;
            opacity: 0.95;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .stat-item {
            text-align: center;
            padding: 40px 20px;
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: #2d3748;
            font-weight: 500;
        }
        
        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 15px;
        }
        
        .section-title p {
            font-size: 1.2rem;
            color: #6c757d;
        }
        
        .feature-card {
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            background: white;
            height: 100%;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 3.5rem;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .feature-card h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .feature-card p {
            color: #6c757d;
            line-height: 1.6;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 100px 0;
            color: white;
            text-align: center;
        }
        
        .cta-section h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .btn-hero {
            padding: 18px 45px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        
        /* Footer */
        footer {
            background: #2d3748;
            color: white;
            padding: 60px 0 30px;
        }
        
        footer h5, footer h6 {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        footer a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        footer a:hover {
            color: white;
        }
        
        .social-icons a {
            font-size: 2rem;
            margin-right: 15px;
            color: white;
            transition: all 0.3s;
        }
        
        .social-icons a:hover {
            transform: translateY(-3px);
            color: #667eea;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-graduation-cap text-primary"></i>
                <span style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    ACADEMIA
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2 px-4" href="/register">Get Started</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Everything You Need to Excel</h1>
            <p>Powerful features to help you stay on top of your academics</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Active Students</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Courses Tracked</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">100K+</div>
                        <div class="stat-label">Grades Recorded</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-title">
                <h2>Comprehensive Academic Tools</h2>
                <p>All the features you need in one platform</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4>GPA Tracking</h4>
                        <p>
                            Automatically calculate your GPA with our smart grading system. 
                            Track progress across semesters and set target goals.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-check feature-icon"></i>
                        <h4>Attendance Monitor</h4>
                        <p>
                            Never miss class again. Track attendance rates and get alerts 
                            when you're below required thresholds.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-tasks feature-icon"></i>
                        <h4>Task Management</h4>
                        <p>
                            Organize assignments, projects, and deadlines. Prioritize tasks 
                            and track completion progress.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-book feature-icon"></i>
                        <h4>Course Management</h4>
                        <p>
                            Keep all course information in one place. Add schedules, 
                            instructor details, and personal notes.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-file-alt feature-icon"></i>
                        <h4>Progress Reports</h4>
                        <p>
                            Generate detailed transcripts and progress reports. 
                            Export to PDF for official documentation.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-calculator feature-icon"></i>
                        <h4>Grade Calculator</h4>
                        <p>
                            Predict final grades and see what you need to achieve 
                            your target GPA. Plan ahead with confidence.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-pie feature-icon"></i>
                        <h4>Analytics Dashboard</h4>
                        <p>
                            Visualize your academic performance with interactive charts 
                            and graphs. Identify trends and areas for improvement.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-bell feature-icon"></i>
                        <h4>Smart Notifications</h4>
                        <p>
                            Get timely reminders for assignments, exams, and classes. 
                            Never miss an important deadline again.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="fas fa-mobile-alt feature-icon"></i>
                        <h4>Mobile Responsive</h4>
                        <p>
                            Access your academic data anywhere, anytime. Fully optimized 
                            for mobile devices and tablets.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Take Control of Your Grades?</h2>
            <p>Join thousands of students already using Academia</p>
            <a href="/register" class="btn btn-light btn-lg btn-hero">
                Get Started Free <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <h5>
                        <i class="fas fa-graduation-cap"></i> ACADEMIA
                    </h5>
                    <p class="text-muted">
                        The complete academic management platform for ambitious students.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/">Home</a></li>
                        <li class="mb-2"><a href="/features">Features</a></li>
                        <li class="mb-2"><a href="/about">About</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                        <li class="mb-2"><a href="/login">Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="mb-3">Connect</h6>
                    <div class="social-icons mb-3">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                    <p class="text-muted small">
                        <i class="fas fa-envelope me-2"></i> support@academia.pk<br>
                        <i class="fas fa-phone me-2"></i> +92 300 1234567
                    </p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center pt-3">
                <p class="mb-1">&copy; 2024 Academia GPA Tracker. All rights reserved.</p>
                <small class="text-muted">Built with Laravel & Bootstrap</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>