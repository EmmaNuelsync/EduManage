<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentResourceController extends Controller
{
    /**
     * Display all accessible resources for the student.
     */
    public function index(Request $request)
    {
        $student = Auth::user();
        $studentProfile = $student->student;
        
        // Get filters from request
        $subject = $request->get('subject');
        $type = $request->get('type');
        $search = $request->get('search');

        // Get accessible resources
        $resources = Resource::published()
            ->forGrade($studentProfile->grade_level)
            ->when($subject, function($query, $subject) {
                return $query->where('subject', 'like', "%{$subject}%");
            })
            ->when($type, function($query, $type) {
                return $query->where('type', $type);
            })
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->with('teacher')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get unique subjects for filter
        $subjects = Resource::published()
            ->distinct()
            ->pluck('subject')
            ->filter()
            ->values();

        return view('student.resources.index', compact('resources', 'subjects', 'studentProfile'));
    }

    /**
     * Display a single resource.
     */
    public function show($id)
    {
        $student = Auth::user();
        $studentProfile = $student->student;
        
        $resource = Resource::published()
            ->forGrade($studentProfile->grade_level)
            ->with('teacher')
            ->findOrFail($id);

        // Check if resource is accessible
        if (!$resource->isAccessibleBy($studentProfile)) {
            abort(403, 'You do not have access to this resource.');
        }

        // Log the access
        ResourceAccessLog::create([
            'resource_id' => $resource->id,
            'student_id' => $student->id,
            'accessed_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Get related resources
        $relatedResources = Resource::published()
            ->forGrade($studentProfile->grade_level)
            ->where('id', '!=', $resource->id)
            ->where('subject', $resource->subject)
            ->limit(4)
            ->get();

        return view('student.resources.show', compact('resource', 'relatedResources'));
    }

    /**
     * Download a resource file.
     */
    public function download($id)
    {
        $student = Auth::user();
        $studentProfile = $student->student;
        
        $resource = Resource::published()
            ->forGrade($studentProfile->grade_level)
            ->findOrFail($id);

        if (!$resource->isAccessibleBy($studentProfile)) {
            abort(403, 'You do not have access to this resource.');
        }

        if ($resource->type !== 'file' || !$resource->file_path) {
            abort(404, 'File not found.');
        }

        // Log the download
        ResourceAccessLog::create([
            'resource_id' => $resource->id,
            'student_id' => $student->id,
            'accessed_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $filePath = storage_path('app/public/' . $resource->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $resource->file_name);
    }

    /**
     * Get student's resource access history.
     */
    public function history()
    {
        $student = Auth::user();
        
        $accessLogs = ResourceAccessLog::with('resource.teacher')
            ->where('student_id', $student->id)
            ->orderBy('accessed_at', 'desc')
            ->paginate(15);

        return view('student.resources.history', compact('accessLogs'));
    }
}