<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - EduManage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .dashboard-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        /* Fade-in animation for cards */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Staggered animation for cards */
        .fade-in:nth-child(1) { transition-delay: 0.1s; }
        .fade-in:nth-child(2) { transition-delay: 0.2s; }
        .fade-in:nth-child(3) { transition-delay: 0.3s; }
        .fade-in:nth-child(4) { transition-delay: 0.4s; }
        .fade-in:nth-child(5) { transition-delay: 0.5s; }

        .footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .welcome-badge {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
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
                    <li class="nav-item">
                        <span class="nav-link text-light">
                            <i class="fas fa-user me-1"></i>
                            Welcome, {{ Auth::user()->name }}!
                        </span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-1"></i>Settings
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('teacher.teacher-profile') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i>Notifications</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Welcome Section -->
    <section class="hero-section text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold mb-3">Teacher Dashboard</h1>
                    <p class="lead mb-0">Manage your classes, assignments, and student interactions efficiently</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge welcome-badge px-3 py-2 fs-6">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Account
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-tasks text-primary fs-1 mb-2"></i>
                            <h5 class="card-title">Active Assignments</h5>
                            <h3 class="text-primary">12</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-users text-success fs-1 mb-2"></i>
                            <h5 class="card-title">Total Students</h5>
                            <h3 class="text-success">45</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle text-warning fs-1 mb-2"></i>
                            <h5 class="card-title">Pending Grading</h5>
                            <h3 class="text-warning">8</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-alt text-info fs-1 mb-2"></i>
                            <h5 class="card-title">Today's Classes</h5>
                            <h3 class="text-info">3</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Teaching Tools</h2>
                <p class="lead text-muted">Access all your teaching resources and management tools</p>
            </div>

            <div class="row g-4">
                <!-- Assignment Management Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-primary">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h5 class="card-title fw-bold text-primary">Assignment Management</h5>
                            <p class="card-text text-muted mb-3">
                                Create, distribute, and manage assignments for your students with ease.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Create new assignments</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Track submission status</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Set deadlines</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Upload resources</li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-rocket me-2"></i>Manage Assignments
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Grade Management Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-success">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h5 class="card-title fw-bold text-success">Grade Management</h5>
                            <p class="card-text text-muted mb-3">
                                Access, update, and analyze student grades and academic performance.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>View student grades</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Update grade records</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Generate reports</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Performance analytics</li>
                            </ul>
                            <a href="#" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-chart-line me-2"></i>Manage Grades
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Attendance Tracking Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-warning">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h5 class="card-title fw-bold text-warning">Attendance Tracking</h5>
                            <p class="card-text text-muted mb-3">
                                Monitor and manage student attendance records efficiently.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Take daily attendance</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>View attendance history</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Generate reports</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Identify patterns</li>
                            </ul>
                            <a href="#" class="btn btn-warning text-white btn-lg w-100">
                                <i class="fas fa-user-check me-2"></i>Track Attendance
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Resource Sharing Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-info">
                                <i class="fas fa-share-alt"></i>
                            </div>
                            <h5 class="card-title fw-bold text-info">Resource Sharing</h5>
                            <p class="card-text text-muted mb-3">
                                Create and share educational materials and resources with students.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Upload study materials</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Share links and resources</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Organize by subject</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Track downloads</li>
                            </ul>
                            <a href="#" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i>Share Resources
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Communication Hub Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-purple">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5 class="card-title fw-bold text-purple">Communication Hub</h5>
                            <p class="card-text text-muted mb-3">
                                Communicate with students through announcements and messaging.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Send announcements</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Class-wide messaging</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Individual chats</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Important updates</li>
                            </ul>
                            <a href="#" class="btn btn-secondary btn-lg w-100 text-black">
                                <i class="fas fa-comment-dots me-2"></i>Start Chatting
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Class Management Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-danger">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                            <h5 class="card-title fw-bold text-danger">Class Management</h5>
                            <p class="card-text text-muted mb-3">
                                Manage your classes, schedules, and student groupings.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>View class schedules</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manage student lists</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Create groups</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Schedule events</li>
                            </ul>
                            <a href="#" class="btn btn-danger btn-lg w-100">
                                <i class="fas fa-cogs me-2"></i>Manage Classes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Activity Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4 class="fw-bold text-primary mb-4">Recent Activity</h4>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-tasks text-primary me-3"></i>
                                        <span>Mathematics assignment submitted by 15 students</span>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-comment text-success me-3"></i>
                                        <span>New message from Sarah Johnson</span>
                                    </div>
                                    <small class="text-muted">4 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-chart-bar text-warning me-3"></i>
                                        <span>Science test grades updated</span>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-bell text-info me-3"></i>
                                        <span>Staff meeting reminder for tomorrow</span>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="fw-bold text-primary mb-4">Upcoming Deadlines</h4>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Physics Project</h6>
                                        <small class="text-danger">Tomorrow</small>
                                    </div>
                                    <p class="mb-1 small text-muted">Grade 10 - Section A</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Math Quiz</h6>
                                        <small class="text-warning">2 days</small>
                                    </div>
                                    <p class="mb-1 small text-muted">Grade 9 - All sections</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Science Report</h6>
                                        <small class="text-info">5 days</small>
                                    </div>
                                    <p class="mb-1 small text-muted">Grade 11 - Section B</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        Empowering educators with innovative tools to enhance teaching effectiveness 
                        and student engagement in the digital age.
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
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Dashboard</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">My Classes</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Calendar</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Resources</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Teacher Guides</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">Contact Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            teacher-support@edumanage.com
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +1 (555) 123-TEACH
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock me-2"></i>
                            Mon-Fri: 8:00 AM - 6:00 PM
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 EduManage Teacher Portal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Teaching Excellence Powered by Technology</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & Custom JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Scroll animation for cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.fade-in');
            
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
                    rect.bottom >= 0
                );
            }
            
            function handleScrollAnimation() {
                cards.forEach(card => {
                    if (isInViewport(card)) {
                        card.classList.add('visible');
                    }
                });
            }
            
            // Initial check
            handleScrollAnimation();
            
            // Check on scroll
            window.addEventListener('scroll', handleScrollAnimation);
            
            // Intersection Observer for better performance
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
                
                cards.forEach(card => {
                    observer.observe(card);
                });
            }
        });
    </script>
</body>
</html>

