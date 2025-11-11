@extends('layouts.resource')

@section('title', 'Resource Sharing - EduManage')

@section('page-title', 'Resource Sharing')
@section('page-description', 'Upload and manage educational resources for your students')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Resources</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalResources }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Downloads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDownloads }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-download fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Views</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalViews }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">My Resources</h4>
                <a href="{{ route('teacher.resources.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Upload New Resource
                </a>
            </div>
        </div>
    </div>

    <!-- Resources Grid -->
    <div class="row">
        @foreach($resources as $resource)
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <i class="{{ $resource->getFileIcon() }} fa-2x text-primary"></i>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('teacher.resources.show', $resource) }}">
                                        <i class="fas fa-eye me-2"></i>View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('teacher.resources.download', $resource) }}">
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('teacher.resources.edit', $resource) }}">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('teacher.resources.destroy', $resource) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <h6 class="card-title">{{ Str::limit($resource->title, 50) }}</h6>
                    <p class="card-text small text-muted">{{ Str::limit($resource->description, 80) }}</p>
                    
                    <div class="resource-meta">
                        <small class="text-muted">
                            <i class="fas fa-download me-1"></i>{{ $resource->download_count }}
                            <i class="fas fa-eye ms-2 me-1"></i>{{ $resource->view_count }}
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">
                        {{ $resource->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $resources->links() }}
        </div>
    </div>
</div>
@endsection