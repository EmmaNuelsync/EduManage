<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard - EduManage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #7e22ce 0%, #a855f7 100%);
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

        .text-purple {
            color: #7e22ce !important;
        }

        .bg-purple {
            background-color: #7e22ce !important;
        }

        .btn-purple {
            background: linear-gradient(135deg, #7e22ce 0%, #a855f7 100%);
            border: none;
            color: white;
        }

        .btn-purple:hover {
            background: linear-gradient(135deg, #6b21a8 0%, #9333ea 100%);
            color: white;
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
            background: linear-gradient(135deg, #581c87 0%, #7e22ce 100%);
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .welcome-badge {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .superadmin-badge {
            background: linear-gradient(135deg, #7e22ce 0%, #a855f7 100%);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-purple sticky-top">
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
                            <i class="fas fa-user-shield me-1"></i>
                            Welcome, {{ Auth::user()->name }}!
                        </span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-1"></i>Admin Controls
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>System Settings</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-users-cog me-2"></i>User Management</a></li>
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
                    <h1 class="display-5 fw-bold mb-3">SuperAdmin Dashboard</h1>
                    <p class="lead mb-0">Complete system administration and management control panel</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge superadmin-badge px-3 py-2 fs-6">
                        <i class="fas fa-user-shield me-2"></i>SuperAdmin Account
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
                            <i class="fas fa-school text-purple fs-1 mb-2"></i>
                            <h5 class="card-title">Total Schools</h5>
                            <h3 class="text-purple">{{ \App\Models\School::count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-chalkboard-teacher text-success fs-1 mb-2"></i>
                            <h5 class="card-title">Active Teachers</h5>
                            <h3 class="text-success">127</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-user-graduate text-warning fs-1 mb-2"></i>
                            <h5 class="card-title">Total Students</h5>
                            <h3 class="text-warning">2,845</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt text-info fs-1 mb-2"></i>
                            <h5 class="card-title">System Admins</h5>
                            <h3 class="text-info">5</h3>
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
                <h2 class="fw-bold text-purple">System Administration</h2>
                <p class="lead text-muted">Complete control over all system modules and configurations</p>
            </div>

            <div class="row g-4">
                <!-- School Management Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-purple">
                                <i class="fas fa-school"></i>
                            </div>
                            <h5 class="card-title fw-bold text-purple">School Management</h5>
                            <p class="card-text text-muted mb-3">
                                Manage all schools in the system, including adding, editing, and removing institutions.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Create new schools</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Edit school information</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manage school profiles</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Delete schools</li>
                            </ul>
                            <a href="{{ route('schools.index') }}" class="btn btn-purple btn-lg w-100">
                                <i class="fas fa-cogs me-2"></i>Manage Schools
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Management Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-success">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <h5 class="card-title fw-bold text-success">User Management</h5>
                            <p class="card-text text-muted mb-3">
                                Oversee all user accounts, roles, permissions, and access levels across the platform.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manage user roles</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Set permissions</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Reset passwords</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Audit user activity</li>
                            </ul>
                            <a href="#" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-user-lock me-2"></i>Manage Users
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Configuration Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-warning">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                            <h5 class="card-title fw-bold text-warning">System Configuration</h5>
                            <p class="card-text text-muted mb-3">
                                Configure global system settings, modules, and platform-wide configurations.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Global settings</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Module management</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>System maintenance</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Backup management</li>
                            </ul>
                            <a href="#" class="btn btn-warning text-white btn-lg w-100">
                                <i class="fas fa-cog me-2"></i>System Settings
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Analytics & Reports Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-info">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="card-title fw-bold text-info">Analytics & Reports</h5>
                            <p class="card-text text-muted mb-3">
                                Access comprehensive analytics and generate system-wide reports and insights.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Platform analytics</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Usage statistics</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Performance reports</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Custom reporting</li>
                            </ul>
                            <a href="#" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-chart-bar me-2"></i>View Analytics
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Security & Audit Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-danger">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="card-title fw-bold text-danger">Security & Audit</h5>
                            <p class="card-text text-muted mb-3">
                                Monitor security events, audit logs, and manage system security configurations.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Security monitoring</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Audit logs</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Security policies</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Compliance reports</li>
                            </ul>
                            <a href="#" class="btn btn-danger btn-lg w-100">
                                <i class="fas fa-eye me-2"></i>Security Center
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Database Management Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card card shadow-sm text-center p-4 fade-in">
                        <div class="card-body">
                            <div class="card-icon text-secondary">
                                <i class="fas fa-database"></i>
                            </div>
                            <h5 class="card-title fw-bold text-secondary">Database Management</h5>
                            <p class="card-text text-muted mb-3">
                                Manage database operations, backups, and perform system maintenance tasks.
                            </p>
                            <ul class="list-unstyled text-start text-muted small mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Database backups</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>System maintenance</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Data integrity checks</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Cleanup operations</li>
                            </ul>
                            <a href="#" class="btn btn-secondary btn-lg w-100">
                                <i class="fas fa-server me-2"></i>Database Tools
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
                    <h4 class="fw-bold text-purple mb-4">System Activity Log</h4>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-school text-purple me-3"></i>
                                        <span>New school "Lincoln High School" was created</span>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-user-cog text-success me-3"></i>
                                        <span>User permissions updated for Sarah Johnson</span>
                                    </div>
                                    <small class="text-muted">4 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-shield-alt text-warning me-3"></i>
                                        <span>Security audit completed successfully</span>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-database text-info me-3"></i>
                                        <span>Automatic system backup completed</span>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="fw-bold text-purple mb-4">Quick Actions</h4>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('schools.create') }}" class="btn btn-purple btn-lg">
                                    <i class="fas fa-plus-circle me-2"></i>Add New School
                                </a>
                                <a href="{{ route('schools.index') }}" class="btn btn-outline-purple btn-lg">
                                    <i class="fas fa-list me-2"></i>View All Schools
                                </a>
                                <a href="#" class="btn btn-outline-success btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Create New Admin
                                </a>
                                <a href="#" class="btn btn-outline-info btn-lg">
                                    <i class="fas fa-download me-2"></i>Export Reports
                                </a>
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
                        Comprehensive educational management platform with complete system administration 
                        and control capabilities for institutional excellence.
                    </p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold">System Modules</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('schools.index') }}" class="text-white text-decoration-none">Schools</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Users</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Reports</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Settings</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold">Admin Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Admin Guide</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">System Documentation</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Security Policies</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">API Documentation</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold">System Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            superadmin@edumanage.com
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +1 (555) 123-ADMIN
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock me-2"></i>
                            24/7 System Monitoring
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-server me-2"></i>
                            System Status: <span class="badge bg-success">Operational</span>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 EduManage SuperAdmin Portal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">System Version: 3.2.1 | Last Updated: Today</p>
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