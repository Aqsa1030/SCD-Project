<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Academia GPA Tracker</title>
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
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 140px 0 80px;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease;
        }
        
        .page-header p {
            font-size: 1.3rem;
            opacity: 0.95;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Section Padding */
        .section-padding {
            padding: 100px 0;
        }
        
        /* Mission Section */
        .mission-img {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s;
        }

        .mission-img:hover {
            transform: scale(1.02);
        }
        
        /* Value Cards */
        .value-card {
            padding: 40px 30px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            height: 100%;
            transition: all 0.3s;
            text-align: center;
        }
        
        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .value-icon {
            font-size: 3.5rem;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .value-card h4 {
            font-weight: 700;
            margin-bottom: 15px;
            color: #2d3748;
        }

        .value-card p {
            color: #6c757d;
            line-height: 1.8;
        }
        
        /* Story Section */
        .story-item {
            padding: 40px;
            background: white;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            position: relative;
            transition: all 0.3s;
        }

        .story-item:hover {
            transform: translateX(10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }
        
        .story-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .story-item h4 {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
        }
        
        /* Team Section */
        .team-card {
            text-align: center;
            padding: 40px 30px;
            border-radius: 20px;
            transition: all 0.3s;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            height: 100%;
        }
        
        .team-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .team-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 25px;
            object-fit: cover;
            border: 5px solid #f0f0f0;
            transition: all 0.3s;
        }

        .team-card:hover .team-avatar {
            border-color: #667eea;
            transform: scale(1.05);
        }

        .team-card h5 {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .team-card .position {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .social-links a {
            color: #6c757d;
            transition: all 0.3s;
            margin: 0 8px;
            font-size: 1.2rem;
        }

        .social-links a:hover {
            color: #667eea;
            transform: translateY(-3px);
        }
        
        /* Statistics Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-card {
            text-align: center;
            padding: 30px;
        }

        .stat-card h2 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .stat-card h5 {
            font-size: 1.3rem;
            font-weight: 500;
            opacity: 0.95;
        }
        
        /* CTA Section */
        .cta-section {
            background: #f8f9fa;
        }

        .btn-cta {
            padding: 18px 50px;
            border-radius: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            transition: all 0.3s;
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        /* Footer */
        footer {
            background: #2d3748;
            color: white;
            padding: 60px 0 30px;
        }
        
        footer h5, footer h6 {
            font-weight: 700;
            margin-bottom: 25px;
        }
        
        footer a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
            display: block;
            margin-bottom: 10px;
        }
        
        footer a:hover {
            color: white;
        }
        
        .social-icons a {
            font-size: 2rem;
            margin-right: 20px;
            color: white;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .social-icons a:hover {
            transform: translateY(-3px);
            color: #667eea;
        }

        footer hr {
            border-color: rgba(255,255,255,0.1);
            margin: 40px 0 30px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.5rem;
            }

            .section-padding {
                padding: 60px 0;
            }

            .stat-card h2 {
                font-size: 3rem;
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
                        <a class="nav-link" href="/features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/about">About</a>
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
            <h1>About Academia</h1>
            <p>Empowering students to achieve academic excellence</p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="display-5 fw-bold mb-4">Our Mission</h2>
                    <p class="lead mb-4">
                        At Academia, we believe every student deserves the tools to succeed academically. 
                        Our mission is to provide a comprehensive, user-friendly platform that simplifies 
                        grade tracking, attendance monitoring, and academic planning.
                    </p>
                    <p style="color: #6c757d; line-height: 1.8;">
                        We're dedicated to helping students stay organized, motivated, and on track to 
                        achieve their educational goals. Whether you're aiming for a 4.0 GPA or just trying 
                        to keep up with your coursework, Academia is here to support your journey.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&h=600&fit=crop" 
                         class="img-fluid mission-img" 
                         alt="Our Mission">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Our Core Values</h2>
                <p class="lead text-muted">The principles that guide everything we do</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-lightbulb value-icon"></i>
                        <h4>Innovation</h4>
                        <p>
                            We constantly innovate to provide cutting-edge features that make 
                            academic tracking easier and more intuitive.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-users value-icon"></i>
                        <h4>Student-Focused</h4>
                        <p>
                            Every feature is designed with students in mind, ensuring the platform 
                            meets real academic needs.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-shield-alt value-icon"></i>
                        <h4>Privacy & Security</h4>
                        <p>
                            Your academic data is precious. We use industry-standard security 
                            to keep your information safe.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-gem value-icon"></i>
                        <h4>Excellence</h4>
                        <p>
                            We strive for excellence in everything - from code quality to 
                            user experience and customer support.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-heart value-icon"></i>
                        <h4>Passion</h4>
                        <p>
                            We're passionate about education and believe in the power of 
                            technology to transform learning.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="value-card">
                        <i class="fas fa-globe value-icon"></i>
                        <h4>Accessibility</h4>
                        <p>
                            Education should be accessible to everyone. Our platform is free 
                            and available to students worldwide.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Our Story</h2>
                <p class="lead text-muted">The journey behind Academia GPA Tracker</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="story-item">
                        <i class="fas fa-lightbulb story-icon"></i>
                        <h4>The Spark of an Idea</h4>
                        <p class="text-muted mb-0">
                            Academia was born from a real student struggle. Like many students, we found ourselves 
                            juggling spreadsheets, notebooks, and sticky notes just to keep track of grades and attendance. 
                            We knew there had to be a better way—a platform designed specifically for students, by students.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="story-item">
                        <i class="fas fa-code story-icon"></i>
                        <h4>Building the Solution</h4>
                        <p class="text-muted mb-0">
                            What started as a small weekend project quickly evolved into something much bigger. We spent 
                            countless hours designing, coding, and refining every feature. Our goal was simple: create a 
                            GPA tracker that's not only powerful but also incredibly easy to use.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="story-item">
                        <i class="fas fa-rocket story-icon"></i>
                        <h4>Launch and Community</h4>
                        <p class="text-muted mb-0">
                            When we finally launched Academia, the response exceeded our wildest expectations. Students 
                            from universities and colleges across Pakistan began using the platform. Their feedback and 
                            encouragement fueled our passion to keep improving and adding new features.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="story-item">
                        <i class="fas fa-chart-line story-icon"></i>
                        <h4>Growing Together</h4>
                        <p class="text-muted mb-0">
                            Today, Academia serves thousands of students helping them track their grades, monitor attendance, 
                            and achieve their academic goals. But we're not stopping here. We continue to listen to our users, 
                            implement their suggestions, and build features that make academic management effortless.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="story-item">
                        <i class="fas fa-star story-icon"></i>
                        <h4>Our Vision for the Future</h4>
                        <p class="text-muted mb-0">
                            We envision Academia becoming the go-to academic companion for students everywhere. We're working 
                            on exciting features like mobile apps for on-the-go tracking, AI-powered study insights to help 
                            you identify patterns in your performance, collaborative study tools for group projects, and seamless 
                            integration with popular learning management systems. The future of academic tracking is bright, 
                            and we're thrilled to have you join us on this journey.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Meet Our Team</h2>
                <p class="lead text-muted">The people behind Academia</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="team-card">
                        <img src="https://ui-avatars.com/api/?name=Aqsa+Aslam&size=150&background=667eea&color=fff&bold=true" 
                             class="team-avatar" 
                             alt="Aqsa Aslam">
                        <h5>Aqsa Aslam</h5>
                        <p class="position">Co-Founder & Lead Developer</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="team-card">
                        <img src="https://ui-avatars.com/api/?name=Kainat+Tahir&size=150&background=764ba2&color=fff&bold=true" 
                             class="team-avatar" 
                             alt="Kainat Tahir">
                        <h5>Kainat Tahir</h5>
                        <p class="position">Co-Founder & Product Designer</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-dribbble"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="section-padding stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h2>10K+</h2>
                        <h5>Active Students</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h2>50K+</h2>
                        <h5>Courses Tracked</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h2>1M+</h2>
                        <h5>Grades Recorded</h5>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h2>99%</h2>
                        <h5>Satisfaction Rate</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding cta-section text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4">Ready to Join Us?</h2>
            <p class="lead text-muted mb-4">
                Start tracking your academic progress today. It's free!
            </p>
            <a href="/register" class="btn btn-cta">
                Get Started Now <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>
                        <i class="fas fa-graduation-cap"></i> ACADEMIA
                    </h5>
                    <p style="color: #cbd5e0;">
                        The complete academic management platform for ambitious students.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h6>Quick Links</h6>
                    <a href="/">Home</a>
                    <a href="/features">Features</a>
                    <a href="/about">About</a>
                    <a href="/contact">Contact</a>
                    <a href="/login">Login</a>
                </div>
                <div class="col-md-4 mb-4">
                    <h6>Connect</h6>
                    <div class="social-icons mb-4">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                    <p style="color: #cbd5e0; line-height: 1.8;">
                        <i class="fas fa-envelope me-2"></i> support@academia.pk<br>
                        <i class="fas fa-phone me-2"></i> +92 300 1234567<br>
                        <i class="fas fa-map-marker-alt me-2"></i> Hassan Abdal, Jallo, Pakistan
                    </p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p style="margin-bottom: 0;">&copy; 2024 Academia GPA Tracker. All rights reserved.</p>
                <small style="color: #cbd5e0;">Built with Laravel & Bootstrap</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>