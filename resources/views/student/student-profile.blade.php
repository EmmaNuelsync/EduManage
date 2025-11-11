<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - EduManage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .profile-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            object-fit: cover;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: none;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: none;
            border-radius: 10px;
        }

        .progress {
            height: 8px;
        }

        .badge-academic {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }

        .badge-attendance {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboards.student') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                EduManage
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('dashboards.student') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('student.student-profile') }}"><i
                                        class="fas fa-user-cog me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i>Notifications</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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

    <!-- Profile Header -->
    <section class="profile-header text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold mb-2">Student Profile</h1>
                    <p class="lead mb-0">Manage your personal information and academic settings</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-light text-success px-3 py-2 fs-6">
                        <i class="fas fa-user-graduate me-2"></i>Student Account
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3 mb-4">
                    <div class="profile-card p-4">
                        <div class="text-center mb-4">
                            <img src="{{ $student->profile_picture ? asset('storage/profile-pictures/' . $student->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=059669&color=fff&size=120' }}"
                                alt="Profile" class="profile-avatar rounded-circle" id="profileImagePreview">

                            <!-- Upload/Change Button -->
                            <div class="mt-3">
                                <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                                    class="d-none" onchange="previewImage(this)">

                                <button type="button" class="btn btn-success btn-sm"
                                    onclick="document.getElementById('profile_picture').click()">
                                    <i class="fas fa-camera me-1"></i>Change Photo
                                </button>

                                @if($student->profile_picture)
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="removeProfilePicture()">
                                        <i class="fas fa-trash me-1"></i>Remove
                                    </button>
                                @endif
                            </div>

                            <!-- Upload Form (Hidden) -->
                            <form id="profilePictureForm" action="{{ route('student.profile.picture.update') }}"
                                method="POST" enctype="multipart/form-data" class="d-none">
                                @csrf
                                @method('PUT')
                                <input type="file" name="profile_picture" id="hiddenProfilePicture" accept="image/*">
                            </form>

                            <!-- Remove Form (Hidden) -->
                            <form id="removePictureForm" action="{{ route('student.profile.picture.remove') }}"
                                method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        
                        <h5 class="mt-3 mb-1 fw-bold text-center">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-2 text-center">
                            {{ $student->grade_level ?? 'Student' }} • {{ $student->section ?? '' }}
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-success">Active</span>
                            <span class="badge badge-academic">Enrolled</span>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="profile-card p-4 mt-4">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#personal" data-bs-toggle="tab">
                                    <i class="fas fa-user me-2"></i>Personal Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#academic" data-bs-toggle="tab">
                                    <i class="fas fa-graduation-cap me-2"></i>Academic
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#performance" data-bs-toggle="tab">
                                    <i class="fas fa-chart-line me-2"></i>Performance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#security" data-bs-toggle="tab">
                                    <i class="fas fa-shield-alt me-2"></i>Security
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Stats -->
                    <div class="profile-card p-4 mt-4">
                        <h6 class="fw-bold mb-3">Academic Stats</h6>
                        
                        <div class="stat-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Overall GPA</span>
                                <strong class="text-success">
                                    {{ $student->gpa ?? 'N/A' }}
                                </strong>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: {{ ($student->gpa ?? 0) * 25 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="stat-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Attendance</span>
                                <strong class="text-warning">
                                    {{ $student->attendance_rate ?? '0' }}%
                                </strong>
                            </div>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-warning" style="width: {{ $student->attendance_rate ?? 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="stat-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Subjects</span>
                                <strong class="text-primary">
                                    {{ $student->subjects ? count(explode(',', $student->subjects)) : '0' }}
                                </strong>
                            </div>
                        </div>
                        
                        <div class="stat-card p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Enrolled Since</span>
                                <strong class="text-info">
                                    {{ $student->enrollment_date ? $student->enrollment_date->format('M Y') : 'N/A' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="profile-card p-4">
                        <div class="tab-content">
                            <!-- Personal Information Tab -->
                            <div class="tab-pane fade show active" id="personal">
                                <h4 class="fw-bold text-success mb-4">Personal Information</h4>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form action="{{ route('student.student-profile.update-personal') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                                value="{{ old('name', $student->user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                                value="{{ old('email', $student->user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                                                value="{{ old('phone', $student->user->phone ?? '') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth"
                                                value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="address" class="form-label">Home Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                                rows="3">{{ old('address', $student->address ?? '') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" id="emergency_contact" name="emergency_contact"
                                                value="{{ old('emergency_contact', $student->emergency_contact ?? '') }}"
                                                placeholder="Name and phone number">
                                            @error('emergency_contact')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="parent_guardian" class="form-label">Parent/Guardian</label>
                                            <input type="text" class="form-control @error('parent_guardian') is-invalid @enderror" id="parent_guardian" name="parent_guardian"
                                                value="{{ old('parent_guardian', $student->parent_guardian ?? '') }}">
                                            @error('parent_guardian')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="medical_info" class="form-label">Medical Information</label>
                                            <textarea class="form-control @error('medical_info') is-invalid @enderror" id="medical_info" name="medical_info" rows="3"
                                                placeholder="Any allergies, conditions, or special requirements...">{{ old('medical_info', $student->medical_info ?? '') }}</textarea>
                                            @error('medical_info')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success px-4">
                                                <i class="fas fa-save me-2"></i>Update Profile
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Academic Information Tab -->
                            <div class="tab-pane fade" id="academic">
                                <h4 class="fw-bold text-success mb-4">Academic Information</h4>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form action="{{ route('student.student-profile.update-academic') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="student_id" class="form-label">Student ID</label>
                                            <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id"
                                                value="{{ old('student_id', $student->student_id ?? '') }}"
                                                placeholder="e.g., STU-2024-001" readonly>
                                            @error('student_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="enrollment_date" class="form-label">Enrollment Date</label>
                                            <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror" id="enrollment_date" name="enrollment_date"
                                                value="{{ old('enrollment_date', $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : '') }}" readonly>
                                            @error('enrollment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="grade_level" class="form-label">Grade Level</label>
                                            <select class="form-control @error('grade_level') is-invalid @enderror" id="grade_level" name="grade_level">
                                                <option value="">Select Grade</option>
                                                <option value="Grade 7" {{ old('grade_level', $student->grade_level) == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                                                <option value="Grade 8" {{ old('grade_level', $student->grade_level) == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                                                <option value="Grade 9" {{ old('grade_level', $student->grade_level) == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                                                <option value="Grade 10" {{ old('grade_level', $student->grade_level) == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                                                <option value="Grade 11" {{ old('grade_level', $student->grade_level) == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                                                <option value="Grade 12" {{ old('grade_level', $student->grade_level) == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                                            </select>
                                            @error('grade_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="section" class="form-label">Section/Class</label>
                                            <input type="text" class="form-control @error('section') is-invalid @enderror" id="section" name="section"
                                                value="{{ old('section', $student->section ?? '') }}"
                                                placeholder="e.g., A, B, C">
                                            @error('section')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="academic_year" class="form-label">Academic Year</label>
                                            <input type="text" class="form-control @error('academic_year') is-invalid @enderror" id="academic_year" name="academic_year"
                                                value="{{ old('academic_year', $student->academic_year ?? '2024-2025') }}"
                                                placeholder="e.g., 2024-2025">
                                            @error('academic_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="homeroom_teacher" class="form-label">Homeroom Teacher</label>
                                            <input type="text" class="form-control @error('homeroom_teacher') is-invalid @enderror" id="homeroom_teacher" name="homeroom_teacher"
                                                value="{{ old('homeroom_teacher', $student->homeroom_teacher ?? '') }}"
                                                readonly>
                                            @error('homeroom_teacher')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="subjects" class="form-label">Enrolled Subjects</label>
                                            <textarea class="form-control @error('subjects') is-invalid @enderror" id="subjects" name="subjects" rows="3"
                                                placeholder="List of enrolled subjects..." readonly>{{ old('subjects', $student->subjects ?? '') }}</textarea>
                                            @error('subjects')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Note:</strong> Some academic information can only be updated by administrators.
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success px-4">
                                                <i class="fas fa-save me-2"></i>Update Academic Info
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Performance Tab -->
                            <div class="tab-pane fade" id="performance">
                                <h4 class="fw-bold text-success mb-4">Academic Performance</h4>
                                
                                <!-- Overall Performance Summary -->
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="stat-card p-3 text-center">
                                            <h3 class="text-success mb-1">{{ $student->gpa ?? 'N/A' }}</h3>
                                            <p class="mb-0 text-muted">Current GPA</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card p-3 text-center">
                                            <h3 class="text-warning mb-1">{{ $student->attendance_rate ?? '0' }}%</h3>
                                            <p class="mb-0 text-muted">Attendance</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card p-3 text-center">
                                            <h3 class="text-info mb-1">{{ $student->completed_assignments ?? '0' }}/{{ $student->total_assignments ?? '0' }}</h3>
                                            <p class="mb-0 text-muted">Assignments</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card p-3 text-center">
                                            <h3 class="text-primary mb-1">{{ $student->rank ?? 'N/A' }}</h3>
                                            <p class="mb-0 text-muted">Class Rank</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subject-wise Performance -->
                                <h5 class="fw-bold mb-3">Subject-wise Performance</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Teacher</th>
                                                <th>Grade</th>
                                                <th>Progress</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($student->subjects_performance) && count($student->subjects_performance) > 0)
                                                @foreach($student->subjects_performance as $subject)
                                                    <tr>
                                                        <td>{{ $subject['name'] }}</td>
                                                        <td>{{ $subject['teacher'] }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $subject['grade_color'] ?? 'secondary' }}">
                                                                {{ $subject['grade'] ?? 'N/A' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $subject['progress_color'] ?? 'info' }}" 
                                                                     style="width: {{ $subject['progress'] ?? 0 }}%"></div>
                                                            </div>
                                                            <small class="text-muted">{{ $subject['progress'] ?? 0 }}%</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $subject['status_color'] ?? 'success' }}">
                                                                {{ $subject['status'] ?? 'Active' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        No performance data available yet.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Recent Grades -->
                                <h5 class="fw-bold mt-4 mb-3">Recent Assessments</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Assessment</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                                <th>Score</th>
                                                <th>Weight</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($student->recent_grades) && count($student->recent_grades) > 0)
                                                @foreach($student->recent_grades as $grade)
                                                    <tr>
                                                        <td>{{ $grade['assessment'] }}</td>
                                                        <td>{{ $grade['subject'] }}</td>
                                                        <td>{{ $grade['date'] }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $grade['score_color'] ?? 'secondary' }}">
                                                                {{ $grade['score'] }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $grade['weight'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">
                                                        No recent assessment data available.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Security Tab -->
                            <div class="tab-pane fade" id="security">
                                <h4 class="fw-bold text-success mb-4">Security Settings</h4>
                                <form action="{{ route('student.student-profile.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password"
                                                name="current_password" required>
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                                required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required>
                                        </div>
                                        <div class="col-12">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                <strong>Security Tip:</strong> Use a strong password with letters, numbers, and symbols.
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success px-4">
                                                <i class="fas fa-key me-2"></i>Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 EduManage Student Portal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Empowering Students for Academic Excellence</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all tabs
            var triggerTabList = [].slice.call(document.querySelectorAll('a[data-bs-toggle="tab"]'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        });

        // Preview image before upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                    
                    // Auto-submit the form when image is selected
                    document.getElementById('hiddenProfilePicture').files = input.files;
                    document.getElementById('profilePictureForm').submit();
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Remove profile picture
        function removeProfilePicture() {
            if (confirm('Are you sure you want to remove your profile picture?')) {
                document.getElementById('removePictureForm').submit();
            }
        }
        
        // Show image preview on hover
        document.addEventListener('DOMContentLoaded', function() {
            const profileImage = document.getElementById('profileImagePreview');
            const changeButton = document.querySelector('button[onclick*="profile_picture"]');
            
            if (profileImage && changeButton) {
                changeButton.addEventListener('mouseenter', function() {
                    profileImage.style.opacity = '0.7';
                    profileImage.style.transition = 'opacity 0.3s ease';
                });
                
                changeButton.addEventListener('mouseleave', function() {
                    profileImage.style.opacity = '1';
                });
            }
        });

        // Auto-calculate age from date of birth
        document.getElementById('date_of_birth')?.addEventListener('change', function() {
            const dob = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            
            // You can display the age somewhere if needed
            console.log('Calculated age:', age);
        });
    </script>
</body>

</html>