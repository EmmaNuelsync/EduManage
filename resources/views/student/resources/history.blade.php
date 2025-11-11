@extends('layouts.resource')

@section('title', 'Resource Access History - EduManage')

@section('page-title', 'Resource Access History')
@section('page-description', 'Track your learning material usage')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Resources Accessed
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $accessLogs->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
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
                                This Month
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $accessLogs->where('accessed_at', '>=', now()->startOfMonth())->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                Files Downloaded
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $accessLogs->where('resource.type', 'file')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-download fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Last Access
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                @if($accessLogs->count() > 0)
                                    {{ $accessLogs->first()->accessed_at->diffForHumans() }}
                                @else
                                    Never
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Access History Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fas fa-history me-2"></i>Your Resource Access History
                </h6>
                <span class="badge bg-light text-primary">
                    {{ $accessLogs->total() }} Records
                </span>
            </div>
        </div>
        
        <div class="card-body">
            @if($accessLogs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="accessHistoryTable">
                    <thead class="table-light">
                        <tr>
                            <th>Resource</th>
                            <th>Type</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Accessed On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accessLogs as $log)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-{{ $log->resource->type == 'file' ? 'file text-primary' : 'link text-success' }} fa-lg me-2"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-1">
                                        <h6 class="mb-0">
                                            <a href="{{ route('student.resources.show', $log->resource->id) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($log->resource->title, 50) }}
                                            </a>
                                        </h6>
                                        @if($log->resource->description)
                                        <small class="text-muted">
                                            {{ Str::limit($log->resource->description, 70) }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $log->resource->type == 'file' ? 'primary' : 'success' }}">
                                    {{ ucfirst($log->resource->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    {{ $log->resource->subject ?? 'General' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $log->resource->teacher->profile_picture ? asset('storage/profile-pictures/' . $log->resource->teacher->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($log->resource->teacher->name) . '&background=1e40af&color=fff&size=30' }}"
                                         alt="{{ $log->resource->teacher->name }}" 
                                         class="rounded-circle me-2" width="30" height="30">
                                    <small>{{ $log->resource->teacher->name }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $log->accessed_at->format('M j, Y') }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $log->accessed_at->format('g:i A') }}
                                    </small>
                                    <br>
                                    <small class="text-info">
                                        {{ $log->accessed_at->diffForHumans() }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('student.resources.show', $log->resource->id) }}" 
                                       class="btn btn-outline-primary" 
                                       title="View Resource">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($log->resource->type == 'file')
                                    <a href="{{ route('student.resources.download', $log->resource->id) }}" 
                                       class="btn btn-outline-success" 
                                       title="Download Again">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @else
                                    <a href="{{ $log->resource->external_link }}" 
                                       target="_blank" 
                                       class="btn btn-outline-info" 
                                       title="Visit Link">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $accessLogs->firstItem() }} to {{ $accessLogs->lastItem() }} 
                    of {{ $accessLogs->total() }} entries
                </div>
                {{ $accessLogs->links() }}
            </div>

            @else
            <div class="text-center py-5">
                <i class="fas fa-history fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No Access History</h4>
                <p class="text-muted">You haven't accessed any resources yet.</p>
                <a href="{{ route('student.resources.index') }}" class="btn btn-primary">
                    <i class="fas fa-book me-2"></i>Browse Resources
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity Timeline -->
    @if($accessLogs->count() > 0)
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-line me-2"></i>Recent Activity
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($accessLogs->take(5) as $log)
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-{{ $log->resource->type == 'file' ? 'primary' : 'success' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $log->resource->title }}</h6>
                                <p class="text-muted mb-1 small">
                                    {{ $log->resource->type == 'file' ? 'File downloaded' : 'Link visited' }}
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $log->accessed_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Access Summary
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $fileCount = $accessLogs->where('resource.type', 'file')->count();
                        $linkCount = $accessLogs->where('resource.type', 'link')->count();
                        $total = $fileCount + $linkCount;
                    @endphp
                    
                    <div class="mb-4">
                        <h6>Resource Type Distribution</h6>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-primary" style="width: {{ $total > 0 ? ($fileCount/$total)*100 : 0 }}%">
                                Files ({{ $fileCount }})
                            </div>
                            <div class="progress-bar bg-success" style="width: {{ $total > 0 ? ($linkCount/$total)*100 : 0 }}%">
                                Links ({{ $linkCount }})
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6>Top Subjects</h6>
                        @php
                            $subjectCounts = $accessLogs->groupBy('resource.subject')->map->count()->sortDesc()->take(5);
                        @endphp
                        
                        @foreach($subjectCounts as $subject => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">{{ $subject ?: 'General' }}</span>
                            <span class="badge bg-secondary">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    
    .timeline-content {
        padding-bottom: 10px;
        border-left: 2px solid #e9ecef;
        padding-left: 15px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add search functionality to the table
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'form-control form-control-sm';
        searchInput.placeholder = 'Search in history...';
        searchInput.style.maxWidth = '250px';
        
        const cardHeader = document.querySelector('.card-header');
        cardHeader.appendChild(searchInput);
        
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#accessHistoryTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
@endpush