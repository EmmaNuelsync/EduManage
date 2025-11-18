@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Schools Management</h1>
        <div>
            <a href="{{ route('dashboards.superadmin') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>Dashboard
            </a>
            <a href="{{ route('schools.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add New School
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Schools Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $school)
                        <tr>
                            <td>{{ $school->id }}</td>
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->address }}</td>
                            <td>{{ $school->phone }}</td>
                            <td>
                                <a href="{{ route('schools.edit', $school) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <form action="{{ route('schools.destroy', $school) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this school?')">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $schools->firstItem() }} to {{ $schools->lastItem() }} of {{ $schools->total() }} schools
                </div>
                {{ $schools->links() }}
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('schools.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus me-2"></i>Add Another School
        </a>
        <a href="{{ route('dashboards.superadmin') }}" class="btn btn-secondary">
            <i class="fas fa-tachometer-alt me-2"></i>Back to Dashboard
        </a>
    </div>
</div>
@endsection