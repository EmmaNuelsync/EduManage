@extends('layouts.resource')

@section('title', $resource->title . ' - EduManage')

@section('page-title', $resource->title)
@section('page-description', 'View resource details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Resource Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-2 text-center">
                            <i class="{{ $resource->getFileIcon() }} fa-4x text-primary mb-3"></i>
                        </div>
                        <div class="col-md-10">
                            <h4>{{ $resource->title }}</h4>
                            @if($resource->description)
                                <p class="text-muted">{{ $resource->description }}</p>
                            @endif
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Type:</strong> 
                                        {{ $resource->type === 'file' ? 'File' : 'External Link' }}
                                    </small>
                                </div>
                                @if($resource->subject)
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Subject:</strong> {{ $resource->subject }}
                                    </small>
                                </div>
                                @endif
                                @if($resource->grade_level)
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Grade Level:</strong> {{ $resource->grade_level }}
                                    </small>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Visibility:</strong> 
                                        {{ $resource->is_public ? 'Public' : 'Private' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center mt-4">
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-eye fa-2x text-info mb-2"></i>
                                <h5>{{ $resource->view_count }}</h5>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-download fa-2x text-success mb-2"></i>
                                <h5>{{ $resource->download_count }}</h5>
                                <small class="text-muted">Downloads</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-calendar fa-2x text-warning mb-2"></i>
                                <h5>{{ $resource->created_at->format('M d, Y') }}</h5>
                                <small class="text-muted">Created</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @if($resource->type === 'file' && $resource->file_path)
                        <a href="{{ route('teacher.resources.download', $resource) }}" 
                           class="btn btn-success w-100 mb-2">
                            <i class="fas fa-download me-2"></i>Download File
                        </a>
                    @elseif($resource->type === 'link')
                        <a href="{{ $resource->external_link }}" 
                           target="_blank" 
                           class="btn btn-info w-100 mb-2">
                            <i class="fas fa-external-link-alt me-2"></i>Visit Link
                        </a>
                    @endif
                    
                    <a href="{{ route('teacher.resources.edit', $resource) }}" 
                       class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Resource
                    </a>
                    
                    <form action="{{ route('teacher.resources.destroy', $resource) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger w-100"
                                onclick="return confirm('Are you sure you want to delete this resource?')">
                            <i class="fas fa-trash me-2"></i>Delete Resource
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">File Information</h5>
                </div>
                <div class="card-body">
                    @if($resource->type === 'file' && $resource->file_path)
                        <p><strong>File Name:</strong><br>{{ $resource->file_name }}</p>
                        <p><strong>File Size:</strong><br>{{ $resource->getFormattedFileSize() }}</p>
                        <p><strong>Uploaded:</strong><br>{{ $resource->created_at->diffForHumans() }}</p>
                    @elseif($resource->type === 'link')
                        <p><strong>External Link:</strong><br>
                            <a href="{{ $resource->external_link }}" target="_blank" class="text-break">
                                {{ $resource->external_link }}
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection