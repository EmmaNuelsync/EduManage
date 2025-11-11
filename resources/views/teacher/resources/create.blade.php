@extends('layouts.resource')

@section('title', 'Upload Resource - EduManage')

@section('page-title', 'Upload New Resource')
@section('page-description', 'Share educational materials with your students')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Debug Info (remove after testing) -->
                        @if(config('app.debug'))
                            <div class="alert alert-info">
                                <strong>Debug Info:</strong>
                                Max upload size: {{ ini_get('upload_max_filesize') }},
                                Post max size: {{ ini_get('post_max_size') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h5>Please fix the following errors:</h5>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('teacher.resources.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">Resource Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="type" class="form-label">Resource Type *</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="type"
                                            name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>File Upload
                                            </option>
                                            <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>External Link
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File Upload Section -->
                            <div id="file-section" class="resource-section">
                                <div class="form-group mb-3">
                                    <label for="file" class="form-label">Select File *</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                                        name="file"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.jpg,.jpeg,.png,.gif">
                                    <small class="form-text text-muted">
                                        Supported formats: PDF, Word, Excel, PowerPoint, Images, ZIP (Max: 10MB)
                                    </small>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- External Link Section -->
                            <div id="link-section" class="resource-section" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="external_link" class="form-label">External Link *</label>
                                    <input type="url" class="form-control @error('external_link') is-invalid @enderror"
                                        id="external_link" name="external_link" value="{{ old('external_link') }}"
                                        placeholder="https://example.com/resource">
                                    @error('external_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                            id="subject" name="subject" value="{{ old('subject') }}"
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
                                            id="grade_level" name="grade_level" value="{{ old('grade_level') }}"
                                            placeholder="e.g., Grade 9, Grade 10">
                                        @error('grade_level')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public"
                                        value="1" checked>
                                    <label class="form-check-label" for="is_public">
                                        Make this resource public (visible to students)
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>Upload Resource
                                </button>
                                <a href="{{ route('teacher.resources.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const fileSection = document.getElementById('file-section');
            const linkSection = document.getElementById('link-section');
            const fileInput = document.getElementById('file');
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const submitBtn = document.getElementById('submit-btn');
            const loading = document.getElementById('loading');
            const form = document.getElementById('resourceForm');

            function toggleSections() {
                const type = typeSelect.value;

                if (type === 'file') {
                    fileSection.style.display = 'block';
                    linkSection.style.display = 'none';
                    fileInput.required = true;
                } else if (type === 'link') {
                    fileSection.style.display = 'none';
                    linkSection.style.display = 'block';
                    fileInput.required = false;
                } else {
                    fileSection.style.display = 'none';
                    linkSection.style.display = 'none';
                }

                if (type === 'file') {
                    fileSection.classList.remove('d-none');
                    linkSection.classList.add('d-none');
                    fileInput.required = true;
                } else if (type === 'link') {
                    fileSection.classList.add('d-none');
                    linkSection.classList.remove('d-none');
                    fileInput.required = false;
                } else {
                    fileSection.classList.add('d-none');
                    linkSection.classList.add('d-none');
                }
            }

            // File selection preview
            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    fileName.textContent = file.name;

                    // Format file size
                    const size = file.size;
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    fileSize.textContent = (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'KB', 'MB', 'GB'][i];

                    filePreview.classList.remove('d-none');
                } else {
                    filePreview.classList.add('d-none');
                }
            });

            // Form submission loading
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                loading.classList.remove('d-none');
            });

            typeSelect.addEventListener('change', toggleSections);
            toggleSections(); // Initial call
        });
    </script>
@endpush