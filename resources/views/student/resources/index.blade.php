@extends('layouts.resource')

@section('title', 'Learning Resources - EduManage')

@section('page-title', 'Learning Resources')
@section('page-description', 'Access educational materials shared by your teachers')

@section('content')
<div class="container-fluid">
    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('student.resources.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Resources</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search by title or description...">
                </div>
                <div class="col-md-3">
                    <label for="subject" class="form-label">Subject</label>
                    <select class="form-select" id="subject" name="subject">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Resource Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="file" {{ request('type') == 'file' ? 'selected' : '' }}>Files</option>
                        <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>External Links</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resources Grid -->
    <div class="row">
        @forelse($resources as $resource)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card resource-card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-{{ $resource->type == 'file' ? 'primary' : 'success' }}">
                                {{ $resource->type == 'file' ? 'File' : 'Link' }}
                            </span>
                            <small class="text-muted">
                                {{ $resource->created_at->diffForHumans() }}
                            </small>
                        </div>
                        
                        <h5 class="card-title text-truncate">{{ $resource->title }}</h5>
                        
                        <p class="card-text text-muted small">
                            {{ Str::limit($resource->description, 100) }}
                        </p>
                        
                        <div class="resource-meta mb-3">
                            <div class="d-flex justify-content-between text-sm text-muted">
                                <span>
                                    <i class="fas fa-book me-1"></i>
                                    {{ $resource->subject ?? 'General' }}
                                </span>
                                <span>
                                    <i class="fas fa-user me-1"></i>
                                    {{ $resource->teacher->name }}
                                </span>
                            </div>
                        </div>

                        @if($resource->type == 'file')
                            <div class="file-info mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-file me-1"></i>
                                    {{ $resource->file_name }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-hdd me-1"></i>
                                    {{ number_format($resource->file_size / 1024, 2) }} KB
                                </small>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('student.resources.show', $resource->id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            
                            @if($resource->type == 'file')
                                <a href="{{ route('student.resources.download', $resource->id) }}" 
                                   class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            @else
                                <a href="{{ $resource->external_link }}" 
                                   target="_blank" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>Visit Link
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Resources Available</h4>
                        <p class="text-muted">No resources are currently available for your grade level.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($resources->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $resources->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .resource-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .resource-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush