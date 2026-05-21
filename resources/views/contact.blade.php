<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Academia GPA Tracker</title>
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
        }
        
        .page-header p {
            font-size: 1.3rem;
            opacity: 0.95;
        }
        
        /* Section Padding */
        .section-padding {
            padding: 100px 0;
        }
        
        /* Contact Cards */
        .contact-card {
            padding: 50px 30px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: 100%;
            text-align: center;
            transition: all 0.3s;
        }
        
        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .contact-icon {
            font-size: 4rem;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .contact-card h5 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .contact-card p {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .contact-card a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }

        .contact-card a:hover {
            color: #764ba2;
        }
        
        /* Form Card */
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 50px;
        }

        .form-card h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .form-card > .text-center > p {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2d3748;
        }

        .form-control, .form-select {
            padding: 15px 20px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        textarea.form-control {
            resize: vertical;
        }
        
        .btn-submit {
            padding: 18px 50px;
            border-radius: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 10px;
            padding: 20px;
        }
        
        /* FAQ Section */
        .faq-section {
            background: #f8f9fa;
        }

        .faq-section h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .accordion-item {
            background: white;
            border-radius: 15px !important;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .accordion-button {
            padding: 25px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 15px !important;
            background: white;
        }

        .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
            border: none;
        }

        .accordion-body {
            padding: 25px 30px;
            color: #6c757d;
            line-height: 1.8;
        }
        
        /* Map Section */
        .map-section iframe {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .map-section h3 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 40px;
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

            .form-card {
                padding: 30px 20px;
            }

            .section-padding {
                padding: 60px 0;
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
                        <a class="nav-link" href="{{ route('features') }}">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('contact') }}">Contact</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2 px-4" href="{{ route('register') }}">Get Started</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2 px-4" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Get In Touch</h1>
            <p>We'd love to hear from you. Send us a message!</p>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-card">
                        <i class="fas fa-envelope contact-icon"></i>
                        <h5>Email Us</h5>
                        <p>Our team is here to help</p>
                        <a href="mailto:support@academia.pk">support@academia.pk</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card">
                        <i class="fas fa-phone contact-icon"></i>
                        <h5>Call Us</h5>
                        <p>Mon-Fri from 9am to 6pm</p>
                        <a href="tel:+923001234567">+92 300 1234567</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card">
                        <i class="fas fa-map-marker-alt contact-icon"></i>
                        <h5>Visit Us</h5>
                        <p>Come say hello</p>
                        <p style="font-weight: 600; color: #2d3748; margin-bottom: 0;">
                            Hassan Abdal, Jallo<br>
                            Punjab, Pakistan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="form-card">
                        <div class="text-center mb-5">
                            <h2>Send Us a Message</h2>
                            <p>Fill out the form below and we'll get back to you within 24 hours</p>
                        </div>

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="John Doe"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="john@example.com"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="+92 300 1234567">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <select class="form-select @error('subject') is-invalid @enderror" 
                                            id="subject" 
                                            name="subject" 
                                            required>
                                        <option value="">Select a subject...</option>
                                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                        <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="bug" {{ old('subject') == 'bug' ? 'selected' : '' }}>Bug Report</option>
                                        <option value="feature" {{ old('subject') == 'feature' ? 'selected' : '' }}>Feature Request</option>
                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" 
                                              name="message" 
                                              rows="6" 
                                              placeholder="Tell us how we can help you..."
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="newsletter" 
                                               name="newsletter"
                                               {{ old('newsletter') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="newsletter">
                                            Send me updates about new features and tips
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-paper-plane me-2"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section-padding faq-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Frequently Asked Questions</h2>
                <p style="color: #6c757d; font-size: 1.1rem;">Quick answers to common questions</p>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="fas fa-question-circle me-2"></i>
                                    How do I get started with Academia?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Simply click the "Get Started" button, create a free account, and you'll be able to 
                                    start tracking your grades immediately. No credit card required!
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <i class="fas fa-question-circle me-2"></i>
                                    Is Academia really free?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! Academia is completely free for students. We believe every student should have 
                                    access to tools that help them succeed academically.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <i class="fas fa-question-circle me-2"></i>
                                    How is my data protected?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We use industry-standard encryption and security measures to protect your data. 
                                    Your academic information is private and will never be shared with third parties.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <i class="fas fa-question-circle me-2"></i>
                                    Can I export my data?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Absolutely! You can generate PDF transcripts and progress reports at any time. 
                                    Your data belongs to you.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <i class="fas fa-question-circle me-2"></i>
                                    Do you offer mobile apps?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Mobile apps are currently in development! For now, our web platform is fully 
                                    responsive and works great on all devices.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="section-padding map-section">
        <div class="container">
            <div class="text-center mb-5">
                <h3>Our Location</h3>
            </div>
            <div class="ratio ratio-21x9">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13363.391562044345!2d72.6790255!3d33.8194868!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df949a1c0c0c0c%3A0x1c0c0c0c0c0c0c0c!2sHassan%20Abdal%2C%20Attock%20District%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1703251234567" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
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
                    <a href="{{ route('features') }}">Features</a>
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('contact') }}">Contact</a>
                    <a href="{{ route('login') }}">Login</a>
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