<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduManage - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.9) 0%, rgba(59, 130, 246, 0.8) 100%);
        }

        .hero-background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://i.pinimg.com/736x/81/04/60/8104603a3d3f5885e2a868965671b542.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: brightness(0.7);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .min-vh-100 {
            min-height: 100vh;
        }

        .role-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
        }

        .role-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .role-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        /* Fade-in animation for roles section */
        .roles-fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .roles-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }
    </style>
</head>

<body>
    <!-- Sticky Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                EduManage
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-light">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-light text-primary">
                            <i class="fas fa-rocket me-2"></i>Get Started
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white">
        <!-- Background Image -->
        <div class="hero-background-image"></div>

        <!-- Content -->
        <div class="container hero-content">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Welcome to EduManage
                    </h1>
                    <p class="lead mb-4 fs-5">
                        A comprehensive school management system designed to streamline educational operations,
                        enhance communication, and improve learning outcomes for all stakeholders.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary fw-bold px-4">
                            Get Started <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#roles" class="btn btn-outline-light btn-lg px-4">
                            Learn More
                        </a>
                    </div>
                </div>
                <!-- Empty column to maintain layout -->
                <div class="col-lg-6">
                    <!-- This space will show the background image -->
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Choose Your Role</h2>
                <p class="lead text-muted">Select your role to access the appropriate dashboard</p>
            </div>

            <div class="row g-4">
                <!-- Super Admin Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="role-card card h-100 shadow-sm text-center p-4 roles-fade-in">
                        <div class="card-body">
                            <div class="role-icon text-primary">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h5 class="card-title fw-bold text-black">Super Administrator</h5>
                            <div class="mt-3">
                                <!-- <span class="badge bg-primary">System Management</span>
                                <span class="badge bg-primary">User Administration</span> -->
                                <ul class="card-text text-muted">
                                    <li>Full system access with administrative privileges across all schools and
                                        modules.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- School Admin Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="role-card card h-100 shadow-sm text-center p-4 roles-fade-in">
                        <div class="card-body">
                            <div class="role-icon text-primary">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h5 class="card-title fw-bold text-black">School Administrator</h5>
                            <div class="mt-3">
                                <!-- <span class="badge bg-primary">School Management</span>
                                <span class="badge bg-primary">Staff Coordination</span> -->
                                <ul class="card-text text-muted">
                                    <li>Manage school operations</li>
                                    <li>Manage staff, students, and academic progress</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teacher Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="role-card card h-100 shadow-sm text-center p-4 roles-fade-in">
                        <div class="card-body">
                            <div class="role-icon text-primary">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h5 class="card-title fw-bold text-black">Teacher</h5>
                            <div class="mt-3">
                                <!-- <span class="badge bg-primary">Grade Management</span>
                                <span class="badge bg-primary">Class Coordination</span> -->
                                <ul class="card-text text-muted">
                                    <li>Manage classes and assignments efficiently</li>
                                    <li>Grade students submission digitally</li>
                                    <li>Track student's attendance and prefromances</li>
                                    <li>Create and share educational resources</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="role-card card h-100 shadow-sm text-center p-4 roles-fade-in">
                        <div class="card-body">
                            <div class="role-icon text-primary">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h5 class="card-title fw-bold text-black">Student</h5>
                            <div class="mt-3">
                                <!-- <span class="badge bg-primary">Course Access</span>
                                <span class="badge bg-primary">Progress Tracking</span> -->
                                <ul class="card-text text-muted">
                                    <li>Access student's materials and assignments</li>
                                    <li>Track academic progress and grades</li>
                                    <li>Communicate with teachers</li>
                                    <li>View class schedules and timetables</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="role-card card h-100 shadow-sm text-center p-4 roles-fade-in">
                        <div class="card-body">
                            <div class="role-icon text-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title fw-bold text-black">Parent</h5>
                            <div class="mt-3">
                                <!-- <span class="badge bg-primary">Progress Monitoring</span>
                                <span class="badge bg-primary">Communication</span> -->
                                <ul class="card-text text-muted">
                                    <li>Manage child's academic progress</li>
                                    <li>View attendance and grade records</li>
                                    <li>Communicate with teachers directly</li>
                                    <li>Receive important notifications</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bursar Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="role-card card h-100 shadow-sm text-center p-4 roles-fade-in">
                        <div class="card-body">
                            <div class="role-icon text-primary">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <h5 class="card-title fw-bold text-black">Bursar</h5>
                            <div class="mt-3">
                                <!-- <span class="badge bg-primary">Financial Management</span>
                                <span class="badge bg-primary">Fee Processing</span> -->
                                <ul class="card-text text-muted">
                                    <li>Manage finances, fees and payments</li>
                                    <li>Financial reporting for the respective school</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Why Choose EduManage?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="text-primary mb-3">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Secure & Reliable</h5>
                    <p class="text-muted">Enterprise-grade security to protect your data and privacy.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="text-primary mb-3">
                        <i class="fas fa-bolt fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Fast & Efficient</h5>
                    <p class="text-muted">Streamlined processes that save time and reduce paperwork.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="text-primary mb-3">
                        <i class="fas fa-headset fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">24/7 Support</h5>
                    <p class="text-muted">Round-the-clock support to help you whenever you need it.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold">
                        <i class="fas fa-graduation-cap me-2"></i>EduManage
                    </h5>
                    <p class="mt-3">
                        Transforming education through innovative technology solutions that connect administrators,
                        teachers, students, and parents in one unified platform.
                    </p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#roles" class="text-white text-decoration-none">Roles</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Documentation</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            123 Education Street, Learning City
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +1 (555) 123-4567
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            support@edumanage.com
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 EduManage. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Designed with ❤️ for better education</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Scroll animation for roles section
        document.addEventListener('DOMContentLoaded', function () {
            const roleCards = document.querySelectorAll('.roles-fade-in');

            // Function to check if element is in viewport
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
                    rect.bottom >= 0
                );
            }

            // Function to handle scroll animation
            function handleScrollAnimation() {
                roleCards.forEach(card => {
                    if (isInViewport(card)) {
                        card.classList.add('visible');
                    }
                });
            }

            // Initial check on page load
            handleScrollAnimation();

            // Check on scroll
            window.addEventListener('scroll', handleScrollAnimation);

            // Optional: Add intersection observer for better performance
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });

                roleCards.forEach(card => {
                    observer.observe(card);
                });
            }
        });
    </script>
</body>

</html>