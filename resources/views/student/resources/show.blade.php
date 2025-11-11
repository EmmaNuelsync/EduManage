@extends('layouts.resource')

@section('title', $resource->title . ' - EduManage')

@section('page-title', 'Resource Details')
@section('page-description', 'View and access learning materials')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Resource Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-book me-2"></i>{{ $resource->title }}
                        </h5>
                        <span class="badge bg-light text-primary fs-6">
                            {{ $resource->type == 'file' ? 'File Resource' : 'External Link' }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Resource Type Badge -->
                    <div class="mb-4">
                        <span class="badge bg-{{ $resource->type == 'file' ? 'primary' : 'success' }} me-2">
                            <i class="fas fa-{{ $resource->type == 'file' ? 'file' : 'link' }} me-1"></i>
                            {{ ucfirst($resource->type) }}
                        </span>
                        <span class="badge bg-secondary me-2">
                            <i class="fas fa-book me-1"></i>
                            {{ $resource->subject ?? 'General' }}
                        </span>
                        <span class="badge bg-info">
                            <i class="fas fa-graduation-cap me-1"></i>
                            {{ $resource->grade_level ?? 'All Grades' }}
                        </span>
                    </div>

                    <!-- Description -->
                    @if($resource->description)
                    <div class="mb-4">
                        <h6 class="text-primary mb-2">Description</h6>
                        <p class="card-text">{{ $resource->description }}</p>
                    </div>
                    @endif

                    <!-- File Details -->
                    @if($resource->type == 'file')
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">File Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-file text-primary me-3 fa-lg"></i>
                                    <div>
                                        <strong>File Name</strong>
                                        <p class="mb-0 text-muted">{{ $resource->file_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-hdd text-primary me-3 fa-lg"></i>
                                    <div>
                                        <strong>File Size</strong>
                                        <p class="mb-0 text-muted">
                                            @if($resource->file_size >= 1048576)
                                                {{ number_format($resource->file_size / 1048576, 2) }} MB
                                            @else
                                                {{ number_format($resource->file_size / 1024, 2) }} KB
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- External Link -->
                    @if($resource->type == 'link' && $resource->external_link)
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">External Link</h6>
                        <div class="alert alert-info">
                            <i class="fas fa-external-link-alt me-2"></i>
                            <strong>External Resource:</strong>
                            <a href="{{ $resource->external_link }}" target="_blank" class="alert-link">
                                {{ $resource->external_link }}
                            </a>
                            <small class="d-block mt-1 text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                This link will open in a new window
                            </small>
                        </div>
                    </div>
                    @endif

                    <!-- Teacher Information -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Shared By</h6>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ $resource->teacher->profile_picture ? asset('storage/profile-pictures/' . $resource->teacher->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($resource->teacher->name) . '&background=1e40af&color=fff&size=50' }}"
                                     alt="{{ $resource->teacher->name }}" 
                                     class="rounded-circle" width="50" height="50">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $resource->teacher->name }}</h6>
                                <p class="text-muted mb-0">Teacher</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 flex-wrap">
                        @if($resource->type == 'file')
                            <a href="{{ route('student.resources.download', $resource->id) }}" 
                               class="btn btn-success btn-lg">
                                <i class="fas fa-download me-2"></i>Download File
                            </a>
                        @else
                            <a href="{{ $resource->external_link }}" 
                               target="_blank" 
                               class="btn btn-info btn-lg">
                                <i class="fas fa-external-link-alt me-2"></i>Visit Resource
                            </a>
                        @endif
                        
                        <a href="{{ route('student.resources.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Resources
                        </a>
                    </div>
                </div>
                
                <div class="card-footer text-muted">
                    <small>
                        <i class="fas fa-calendar me-1"></i>
                        Shared on {{ $resource->created_at->format('F j, Y \a\t g:i A') }}
                        @if($resource->published_at)
                            • Published on {{ $resource->published_at->format('F j, Y') }}
                        @endif
                    </small>
                </div>
            </div>

            <!-- Resource Preview (for common file types) -->
            @if($resource->type == 'file')
            <div class="card shadow mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-eye me-2"></i>File Preview
                    </h6>
                </div>
                <div class="card-body text-center">
                    @php
                        $extension = strtolower(pathinfo($resource->file_name, PATHINFO_EXTENSION));
                    @endphp
                    
                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                        <img src="{{ asset('storage/' . $resource->file_path) }}" 
                             alt="{{ $resource->title }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 400px;">
                        <p class="text-muted mt-2">Image Preview</p>
                    
                    @elseif($extension == 'pdf')
                        <div class="alert alert-info">
                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                            <p class="mb-2">PDF files can be previewed after downloading.</p>
                            <a href="{{ route('student.resources.download', $resource->id) }}" 
                               class="btn btn-danger">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </a>
                        </div>
                    
                    @else
                        <div class="alert alert-secondary">
                            <i class="fas fa-file fa-3x text-muted mb-3"></i>
                            <p class="mb-2">Preview not available for this file type.</p>
                            <p class="text-muted small">
                                Download the file to view its contents.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Resources -->
            @if($relatedResources->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-link me-2"></i>Related Resources
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($relatedResources as $related)
                    <div class="card mb-3 border-0 bg-light">
                        <div class="card-body py-3">
                            <h6 class="card-title mb-1">
                                <a href="{{ route('student.resources.show', $related->id) }}" 
                                   class="text-decoration-none">
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    {{ $related->subject ?? 'General' }}
                                </small>
                                <span class="badge bg-{{ $related->type == 'file' ? 'primary' : 'success' }} badge-sm">
                                    {{ $related->type == 'file' ? 'File' : 'Link' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('student.resources.index') }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-th-list me-2"></i>Browse All Resources
                        </a>
                        <a href="{{ route('student.resources.history') }}" 
                           class="btn btn-outline-info btn-sm">
                            <i class="fas fa-history me-2"></i>View Access History
                        </a>
                        @if($resource->type == 'file')
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-print me-2"></i>Print Details
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Resource Statistics -->
            <div class="card shadow mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Resource Info
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-primary mb-0">
                                    {{ $resource->accessLogs->count() }}
                                </h4>
                                <small class="text-muted">Total Views</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-success mb-0">
                                    {{ $resource->created_at->diffForHumans() }}
                                </h4>
                                <small class="text-muted">Added</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-sm {
        font-size: 0.7em;
    }
    
    .card-header {
        border-bottom: 2px solid rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Add confirmation for external links
    document.addEventListener('DOMContentLoaded', function() {
        const externalLinks = document.querySelectorAll('a[target="_blank"]');
        externalLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Optional: Add analytics or tracking here
                console.log('External link clicked:', this.href);
            });
        });
    });
</script>
@endpush