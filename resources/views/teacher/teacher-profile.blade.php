<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profile - EduManage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
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
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border: none;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: none;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboards.teacher') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                EduManage
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('dashboards.teacher') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('teacher.teacher-profile') }}"><i
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
                    <h1 class="display-5 fw-bold mb-2">Teacher Profile</h1>
                    <p class="lead mb-0">Manage your personal information and account settings</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-light text-primary px-3 py-2 fs-6">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Account
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
                            <img src="{{ $teacher->profile_picture ? asset('storage/profile-pictures/' . $teacher->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($teacher->name) . '&background=1e40af&color=fff&size=120' }}"
                                alt="Profile" class="profile-avatar rounded-circle" id="profileImagePreview">

                            <!-- Upload/Change Button -->
                            <div class="mt-3">
                                <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                                    class="d-none" onchange="previewImage(this)">

                                <button type="button" class="btn btn-primary btn-sm"
                                    onclick="document.getElementById('profile_picture').click()">
                                    <i class="fas fa-camera me-1"></i>Change Photo
                                </button>

                                @if($teacher->profile_picture)
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="removeProfilePicture()">
                                        <i class="fas fa-trash me-1"></i>Remove
                                    </button>
                                @endif
                            </div>

                            <!-- Upload Form (Hidden) -->
                            <form id="profilePictureForm" action="{{ route('profile.picture.update') }}"
                                method="POST" enctype="multipart/form-data" class="d-none">
                                @csrf
                                @method('PUT')
                                <input type="file" name="profile_picture" id="hiddenProfilePicture" accept="image/*">
                            </form>

                            <!-- Remove Form (Hidden) -->
                            <form id="removePictureForm" action="{{ route('profile.picture.remove') }}"
                                method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        
                        <h5 class="mt-3 mb-1 fw-bold text-center">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-2 text-center">Teacher</p>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-primary">Active</span>
                            <span class="badge bg-success">Verified</span>
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
                                <a class="nav-link" href="#professional" data-bs-toggle="tab">
                                    <i class="fas fa-briefcase me-2"></i>Professional
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#security" data-bs-toggle="tab">
                                    <i class="fas fa-shield-alt me-2"></i>Security
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#preferences" data-bs-toggle="tab">
                                    <i class="fas fa-cog me-2"></i>Preferences
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Stats -->
                    <div class="profile-card p-4 mt-4">
                        <h6 class="fw-bold mb-3">Teaching Stats</h6>
                        <div class="stat-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Classes</span>
                                <strong class="text-primary">
                                    {{ $teacher->classes_assigned ? count(explode(',', $teacher->classes_assigned)) : '0' }}
                                </strong>
                            </div>
                        </div>
                        <div class="stat-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Subjects</span>
                                <strong class="text-success">
                                    {{ $teacher->subjects ? count(explode(',', $teacher->subjects)) : '0' }}
                                </strong>
                            </div>
                        </div>
                        <div class="stat-card p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Member Since</span>
                                <strong class="text-warning">
                                    {{ $teacher->join_date ? $teacher->join_date->format('M Y') : 'N/A' }}
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
                                <h4 class="fw-bold text-primary mb-4">Personal Information</h4>

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

                                <form action="{{ route('teacher.teacher-profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                                value="{{ old('name', $teacher->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                                value="{{ old('email', $teacher->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                                                value="{{ old('phone', $teacher->phone ?? '') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="department" class="form-label">Department</label>
                                            <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department"
                                                value="{{ old('department', $teacher->department ?? '') }}">
                                            @error('department')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                                rows="3">{{ old('address', $teacher->address ?? '') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="bio" class="form-label">Bio</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4"
                                                placeholder="Tell us about yourself and your teaching philosophy...">{{ old('bio', $teacher->bio ?? '') }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-save me-2"></i>Update Profile
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Professional Information Tab -->
                            <div class="tab-pane fade" id="professional">
                                <h4 class="fw-bold text-primary mb-4">Professional Information</h4>

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

                                <form action="{{ route('teacher.teacher-profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="employee_id" class="form-label">Employee ID</label>
                                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id"
                                                value="{{ old('employee_id', $teacher->employee_id ?? '') }}"
                                                placeholder="e.g., TEA-2024-001">
                                            @error('employee_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="join_date" class="form-label">Join Date</label>
                                            <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date"
                                                value="{{ old('join_date', $teacher->join_date ? $teacher->join_date->format('Y-m-d') : '') }}">
                                            @error('join_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="qualification" class="form-label">Highest Qualification</label>
                                            <input type="text" class="form-control @error('qualification') is-invalid @enderror" id="qualification" name="qualification"
                                                value="{{ old('qualification', $teacher->qualification ?? '') }}"
                                                placeholder="e.g., M.Sc. in Mathematics">
                                            @error('qualification')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="subjects" class="form-label">Subjects Taught</label>
                                            <input type="text" class="form-control @error('subjects') is-invalid @enderror" id="subjects" name="subjects"
                                                value="{{ old('subjects', $teacher->subjects ?? '') }}"
                                                placeholder="e.g., Mathematics, Physics">
                                            @error('subjects')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="classes_assigned" class="form-label">Classes Assigned</label>
                                            <input type="text" class="form-control @error('classes_assigned') is-invalid @enderror" id="classes_assigned" name="classes_assigned"
                                                value="{{ old('classes_assigned', $teacher->classes_assigned ?? '') }}"
                                                placeholder="e.g., Grade 9A, Grade 10B">
                                            @error('classes_assigned')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="work_schedule" class="form-label">Work Schedule</label>
                                            <input type="text" class="form-control @error('work_schedule') is-invalid @enderror" id="work_schedule" name="work_schedule"
                                                value="{{ old('work_schedule', $teacher->work_schedule ?? '') }}"
                                                placeholder="e.g., Monday - Friday, 8:00 AM - 4:00 PM">
                                            @error('work_schedule')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-save me-2"></i>Update Professional Info
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Security Tab -->
                            <div class="tab-pane fade" id="security">
                                <h4 class="fw-bold text-primary mb-4">Security Settings</h4>
                                <form action="{{ route('teacher.teacher-profile.password') }}" method="POST">
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
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="two_factor">
                                                <label class="form-check-label" for="two_factor">
                                                    Enable Two-Factor Authentication
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-key me-2"></i>Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Preferences Tab -->
                            <div class="tab-pane fade" id="preferences">
                                <h4 class="fw-bold text-primary mb-4">Preferences</h4>
                                <form>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="language" class="form-label">Language</label>
                                            <select class="form-select" id="language">
                                                <option selected>English</option>
                                                <option>Spanish</option>
                                                <option>French</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="timezone" class="form-label">Timezone</label>
                                            <select class="form-select" id="timezone">
                                                <option selected>(UTC-05:00) Eastern Time</option>
                                                <option>(UTC-06:00) Central Time</option>
                                                <option>(UTC-07:00) Mountain Time</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="email_notifications"
                                                    checked>
                                                <label class="form-check-label" for="email_notifications">
                                                    Email Notifications
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="sms_notifications">
                                                <label class="form-check-label" for="sms_notifications">
                                                    SMS Notifications
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="assignment_reminders"
                                                    checked>
                                                <label class="form-check-label" for="assignment_reminders">
                                                    Assignment Deadline Reminders
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary px-4">
                                                <i class="fas fa-save me-2"></i>Save Preferences
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
    <footer class="footer text-white py-4 mt-5">
        <div class="container">
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
    </script>
</body>

</html>