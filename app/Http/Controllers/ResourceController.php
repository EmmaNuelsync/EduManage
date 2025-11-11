<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources = Resource::where('teacher_id', Auth::id())
            ->latest()
            ->paginate(12);

        // Get stats - FIXED: Calculate stats properly
        $totalResources = Resource::where('teacher_id', Auth::id())->count();
        $totalDownloads = Resource::where('teacher_id', Auth::id())->sum('download_count');
        $totalViews = Resource::where('teacher_id', Auth::id())->sum('view_count');

        return view('teacher.resources.index', compact('resources', 'totalResources', 'totalDownloads', 'totalViews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.resources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== STARTING RESOURCE UPLOAD ===');

        // Log all request data (except file content)
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request headers:', $request->headers->all());
        \Log::info('Request has file: ' . ($request->hasFile('file') ? 'YES' : 'NO'));
        \Log::info('Request all data:', $request->except('file')); // Exclude file binary data

        // Check if POST data is empty (happens when file is too large)
        if (empty($request->all()) && $request->getContent() > 0) {
            \Log::error('POST DATA EMPTY - File too large or PHP limits exceeded');
            \Log::info('Content length: ' . $request->header('content-length'));
            \Log::info('PHP upload_max_filesize: ' . ini_get('upload_max_filesize'));
            \Log::info('PHP post_max_size: ' . ini_get('post_max_size'));

            return redirect()->back()
                ->withInput()
                ->with('error', 'The file is too large. Maximum allowed size is ' . ini_get('upload_max_filesize'));
        }

        // Check if basic fields exist
        if (!$request->has('title')) {
            \Log::warning('Missing title field in request');
        }
        if (!$request->has('type')) {
            \Log::warning('Missing type field in request');
        }

        try {
            \Log::info('Starting validation...');

            $rules = [
                'title' => 'required|string|max:255',
                'type' => 'required|in:file,link',
                'description' => 'nullable|string',
                'subject' => 'nullable|string|max:100',
                'grade_level' => 'nullable|string|max:50',
                'is_public' => 'sometimes|boolean',
            ];

            // Conditional validation
            $type = $request->type;
            \Log::info('Resource type: ' . $type);

            if ($type === 'file') {
                $rules['file'] = 'required|file|max:10240';
                $rules['external_link'] = 'nullable|url';
                \Log::info('File upload validation rules applied');
            } else if ($type === 'link') {
                $rules['external_link'] = 'required|url';
                \Log::info('External link validation rules applied');
            }

            \Log::info('Validation rules to be applied:', $rules);

            $validated = $request->validate($rules);
            \Log::info('✅ Validation passed successfully');
            \Log::info('Validated data:', $validated);

            // Build resource data
            $resourceData = [
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'subject' => $validated['subject'] ?? null,
                'grade_level' => $validated['grade_level'] ?? null,
                'is_public' => (bool) ($validated['is_public'] ?? true),
                'teacher_id' => auth()->id(),
            ];

            \Log::info('Resource data prepared:', $resourceData);

            // Handle file upload
            if ($request->type === 'file' && $request->hasFile('file')) {
                $file = $request->file('file');
                \Log::info('File details:', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError(),
                ]);

                if (!$file->isValid()) {
                    \Log::error('File upload failed with error: ' . $file->getError());
                    throw new \Exception('File upload failed: ' . $file->getErrorMessage());
                }

                // Check storage
                \Log::info('Storage disk: public');
                \Log::info('Storage path exists: ' . (is_dir(storage_path('app/public')) ? 'YES' : 'NO'));

                try {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    \Log::info('Attempting to store file as: ' . $fileName);

                    $filePath = $file->storeAs('resources', $fileName, 'public');
                    \Log::info('✅ File stored successfully at: ' . $filePath);

                    $resourceData['file_path'] = $filePath;
                    $resourceData['file_name'] = $file->getClientOriginalName();
                    $resourceData['file_size'] = $file->getSize();

                } catch (\Exception $e) {
                    \Log::error('File storage failed: ' . $e->getMessage());
                    throw new \Exception('Could not store file: ' . $e->getMessage());
                }
            }

            // Handle external link
            if ($request->type === 'link') {
                $resourceData['external_link'] = $validated['external_link'];
                \Log::info('External link set: ' . $resourceData['external_link']);
            }

            // Create the resource
            \Log::info('Attempting to create resource in database...');
            try {
                $resource = Resource::create($resourceData);
                \Log::info('✅ Resource created successfully with ID: ' . $resource->id);
            } catch (\Exception $e) {
                \Log::error('Database creation failed: ' . $e->getMessage());
                \Log::error('SQL error: ' . $e->getMessage());
                throw new \Exception('Could not save resource to database: ' . $e->getMessage());
            }

            \Log::info('=== RESOURCE UPLOAD COMPLETED SUCCESSFULLY ===');

            return redirect()->route('teacher.resources.index')
                ->with('success', 'Resource uploaded successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ VALIDATION FAILED:');
            \Log::error('Validation errors:', $e->errors());
            \Log::error('Request data that failed validation:', $request->all());

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            \Log::error('❌ GENERAL EXCEPTION:');
            \Log::error('Error message: ' . $e->getMessage());
            \Log::error('Error code: ' . $e->getCode());
            \Log::error('File: ' . $e->getFile());
            \Log::error('Line: ' . $e->getLine());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Check for specific common errors
            if (str_contains($e->getMessage(), 'No such file or directory')) {
                $errorMsg = 'Storage directory not found. Please check your storage configuration.';
            } elseif (str_contains($e->getMessage(), 'disk')) {
                $errorMsg = 'Storage disk configuration error.';
            } elseif (str_contains($e->getMessage(), 'SQL')) {
                $errorMsg = 'Database error. Please check if all required fields exist in the database.';
            } else {
                $errorMsg = 'An error occurred while uploading the resource: ' . $e->getMessage();
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMsg);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        // Check if resource belongs to the teacher
        if ($resource->teacher_id !== Auth::id()) {
            abort(403);
        }


        // Increment view count
        $resource->increment('view_count');

        return view('teacher.resources.show', compact('resource'));
    }

    public function download(Resource $resource)
    {
        // Check if resource belongs to the teacher
        if ($resource->teacher_id !== Auth::id() && !$resource->is_public) {
            abort(403);
        }

        if ($resource->type !== 'file' || !$resource->file_path) {
            return redirect()->back()->with('error', 'File not available for download.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($resource->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Increment download count
        $resource->increment('download_count');

        //Get file content and return download response
        $fileContent = Storage::disk('public')->path($resource->file_path);
        $fileName = $resource->file_name ?: basename($resource->file_path);

        return response()->streamDownload(function () use ($fileContent) {
            echo $fileContent;
        }, $fileName);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        if ($resource->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('teacher.resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        if ($resource->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'nullable|string|max:100',
            'grade_level' => 'nullable|string|max:50',
            'is_public' => 'boolean'
        ]);

        $resource->update($validated);

        return redirect()->route('teacher.resources.index')
            ->with('success', 'Resource updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        if ($resource->teacher_id !== Auth::id()) {
            abort(403);
        }

        //Delete file from storage if exists
        if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return redirect()->route('teacher.resources.index')
            ->with('success', 'Resource deleted successfully!');
    }

    public function getStats()
    {
        $totalResources = Resource::where('teacher_id', Auth::id())->count();
        $totalDownloads = Resource::where('teacher_id', Auth::id())->sum('download_count');
        $totalViews = Resource::where('teacher_id', Auth::id())->sum('view_count');
        $recentResources = Resource::where('teacher_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return compact('totalResources', 'totalDownloads', 'totalViews', 'recentResources');
    }
}