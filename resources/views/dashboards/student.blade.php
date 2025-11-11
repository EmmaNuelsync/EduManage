<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - EduManage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
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
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .welcome-badge {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        
        .text-purple {
            color: #8b5cf6;
        }
        
        .btn-purple {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
            color: white;
        }
        
        .btn-purple:hover {
            background-color: #7c3aed;
            border-color: #7c3aed;
            color: white;
        }
        
        .progress {
            height: 8px;
        }
        
        .subject-card {
            border-left: 4px solid;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
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
                            <li><a class="dropdown-item" href="{{ route('student.student-profile') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
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
                    <h1 class="display-5 fw-bold mb-3">Student Dashboard</h1>
                    <p class="lead mb-0">Access your courses, assignments, and academic resources in one place</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge welcome-badge px-3 py-2 fs-6">
                        <i class="fas fa-user-graduate me-2"></i>Student Account
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
                            <i class="fas fa-book text-primary fs-1 mb-2"></i>
                            <h5 class="card-title">Active Courses</h5>
                            <h3 class="text-primary">5</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-tasks text-success fs-1 mb-2"></i>
                            <h5 class="card-title">Pending Assignments</h5>
                            <h3 class="text-success">7</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-alt text-warning fs-1 mb-2"></i>
                            <h5 class="card-title">Today's Classes</h5>
                            <h3 class="text-warning">4</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line text-info fs-1 mb-2"></i>
                            <h5 class="card-title">Current GPA</h5>
                            <h3 class="text-info">3.8</h3>
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
                <h2 class="fw-bold text-success">Learning Tools</h2>
                <p class="lead text-muted">Access all your learning resources and academic tools</p>
            </div>

            <div class="row g-4">
                <!-- My Courses Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-primary">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h5 class="card-title fw-bold text-primary">My Courses</h5>
                            <p class="card-text text-muted mb-3">
                                Access all your enrolled courses, materials, and learning resources.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>View course materials</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Access lecture notes</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Download resources</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Track progress</li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-book me-2"></i>View Courses
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Assignments Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-success">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h5 class="card-title fw-bold text-success">Assignments</h5>
                            <p class="card-text text-muted mb-3">
                                View, submit, and track all your assignments and projects.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>View pending assignments</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Submit work online</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Check submission status</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>View feedback</li>
                            </ul>
                            <a href="#" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-tasks me-2"></i>View Assignments
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Grades & Progress Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-warning">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h5 class="card-title fw-bold text-warning">Grades & Progress</h5>
                            <p class="card-text text-muted mb-3">
                                Track your academic performance and progress across all subjects.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>View current grades</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Track grade trends</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Performance analytics</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Academic standing</li>
                            </ul>
                            <a href="#" class="btn btn-warning text-white btn-lg w-100">
                                <i class="fas fa-chart-line me-2"></i>View Grades
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Study Resources Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-info">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5 class="card-title fw-bold text-info">Study Resources</h5>
                            <p class="card-text text-muted mb-3">
                                Access additional learning materials and study resources.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Download study guides</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Access practice tests</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Watch video lessons</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Explore reference materials</li>
                            </ul>
                            <a href="{{ route('student.resources.index') }}" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-download me-2"></i>Access Resources
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Communication Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-purple">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5 class="card-title fw-bold text-purple">Communication</h5>
                            <p class="card-text text-muted mb-3">
                                Connect with teachers and classmates through messaging and forums.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Message teachers</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Class discussions</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Group collaboration</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Announcements</li>
                            </ul>
                            <a href="#" class="btn btn-purple btn-lg w-100">
                                <i class="fas fa-comment-dots me-2"></i>Start Chatting
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Schedule & Calendar Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-danger">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h5 class="card-title fw-bold text-danger">Schedule & Calendar</h5>
                            <p class="card-text text-muted mb-3">
                                View your class schedule, deadlines, and academic calendar.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>View class timetable</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Track assignment deadlines</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Exam schedules</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Academic events</li>
                            </ul>
                            <a href="#" class="btn btn-danger btn-lg w-100">
                                <i class="fas fa-calendar me-2"></i>View Schedule
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Current Courses & Progress Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h4 class="fw-bold text-success mb-4">My Courses & Progress</h4>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card subject-card border-left-primary shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title text-primary">Mathematics</h5>
                                <span class="badge bg-primary">Grade 10</span>
                            </div>
                            <p class="card-text text-muted">Mr. Johnson</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Course Progress</small>
                                    <small>65%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: 65%"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-tasks me-1"></i> 3 assignments due</span>
                                <span class="text-muted">Current: B+</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card subject-card border-left-success shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title text-success">Science</h5>
                                <span class="badge bg-success">Grade 10</span>
                            </div>
                            <p class="card-text text-muted">Ms. Rodriguez</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Course Progress</small>
                                    <small>78%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 78%"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-tasks me-1"></i> 1 assignment due</span>
                                <span class="text-muted">Current: A-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card subject-card border-left-warning shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title text-warning">English Literature</h5>
                                <span class="badge bg-warning">Grade 10</span>
                            </div>
                            <p class="card-text text-muted">Mrs. Patterson</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Course Progress</small>
                                    <small>52%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 52%"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-tasks me-1"></i> 2 assignments due</span>
                                <span class="text-muted">Current: B</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Activity & Upcoming Deadlines Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4 class="fw-bold text-success mb-4">Recent Activity</h4>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-check-circle text-success me-3"></i>
                                        <span>Mathematics assignment submitted successfully</span>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-comment text-primary me-3"></i>
                                        <span>New message from Mr. Johnson (Math Teacher)</span>
                                    </div>
                                    <small class="text-muted">4 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-alt text-warning me-3"></i>
                                        <span>Science test grade updated: 92% (A-)</span>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-bell text-info me-3"></i>
                                        <span>New study material available for English Literature</span>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="fw-bold text-success mb-4">Upcoming Deadlines</h4>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Physics Lab Report</h6>
                                        <small class="text-danger">Tomorrow</small>
                                    </div>
                                    <p class="mb-1 small text-muted">Science - Ms. Rodriguez</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Math Problem Set</h6>
                                        <small class="text-warning">2 days</small>
                                    </div>
                                    <p class="mb-1 small text-muted">Mathematics - Mr. Johnson</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">English Essay</h6>
                                        <small class="text-info">5 days</small>
                                    </div>
                                    <p class="mb-1 small text-muted">English Literature - Mrs. Patterson</p>
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
                        Empowering students with innovative tools to enhance learning effectiveness 
                        and academic success in the digital age.
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
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">My Courses</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Calendar</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Resources</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Student Guides</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">Contact Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            student-support@edumanage.com
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +1 (555) 123-LEARN
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
                    <p class="mb-0">&copy; 2025 EduManage Student Portal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Learning Excellence Powered by Technology</p>
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