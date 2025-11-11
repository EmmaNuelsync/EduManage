@extends('layouts.resource')

@section('title', 'Edit Resource - EduManage')

@section('page-title', 'Edit Resource')
@section('page-description', 'Update resource information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('teacher.resources.update', $resource) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Resource Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $resource->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $resource->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" name="subject" value="{{ old('subject', $resource->subject) }}"
                                           placeholder="e.g., Mathematics, Science">
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="grade_level" class="form-label">Grade Level</label>
                                    <input type="text" class="form-control @error('grade_level') is-invalid @enderror" 
                                           id="grade_level" name="grade_level" value="{{ old('grade_level', $resource->grade_level) }}"
                                           placeholder="e.g., Grade 9, Grade 10">
                                    @error('grade_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" 
                                    {{ old('is_public', $resource->is_public) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_public">
                                    Make this resource public (visible to students)
                                </label>
                            </div>
                        </div>

                        <!-- Display current file/link info -->
                        @if($resource->type === 'file')
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Current File:</strong> {{ $resource->file_name }}
                                ({{ $resource->getFormattedFileSize() }})
                            </div>
                        @elseif($resource->type === 'link')
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Current Link:</strong> 
                                <a href="{{ $resource->external_link }}" target="_blank">{{ $resource->external_link }}</a>
                            </div>
                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Resource
                            </button>
                            <a href="{{ route('teacher.resources.index') }}" class="btn btn-secondary">Cancel</a>
                            <a href="{{ route('teacher.resources.show', $resource) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>View Resource
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection