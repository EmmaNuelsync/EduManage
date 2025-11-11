<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'external_link',
        'type',
        'subject',
        'subject_id',
        'accessible_grades',
        'accessible_sections',
        'is_published',
        'published_at',
        'grade_level',
        'is_public',
        'download_count',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'accessible_grades' => 'array',
        'accessible_sections' => 'array',
        'is_published' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    //Get the subject associated with the resource
    public function subject()
    {
        // return $this->belongsTo(Subject::class);
    }

    //Get students who accessed the resource
    public function accessLogs()
    {
        return $this->hasMany(ResourceAccessLog::class);
    }

    //Scope for published resources
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('is_public', true);
    }

    //Scope for resources accessible by specific grade.
    public function scopeForGrade($query, $grade)
    {
        return $query->where(function ($q) use ($grade) {
            $q->whereNull('accessible_grades')
              ->orWhereJsonContains('accessible_grades', $grade);
        });
    }

    //Check if resource is accessible by student.
    public function isAccessibleBy($student)
    {
        if (!$this->is_published || !$this->is_public) {
            return false;
        }

        // Check grade level access
        if ($this->accessible_grades && !in_array($student->grade_level, $this->accessible_grades)) {
            return false;
        }

        // Check section access
        if ($this->accessible_sections && !in_array($student->section, $this->accessible_sections)) {
            return false;
        }

        return true;
    }

    public function classes()
    {
        // return $this->belongsToMany(Classroom::class, 'resource_classroom');
    }

    //Helper method to get file icon
    public function getFileicon()
    {
        if ($this->type === 'link') {
            return 'fas fa-link';
        }

        if (!$this->file_path) {
            return 'fas fa-file';
        }

        $extension = pathinfo($this->file_path, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'pdf':
                return 'fas fa-file-pdf';
            case 'doc':
            case 'docx':
                return 'fas fa-file-word';
            case 'xls':
            case 'xlsx':
                return 'fas fa-file-excel';
            case 'ppt':
            case 'pptx':
                return 'fas fa-file-powerpoint';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'fas fa-file-image';
            case 'zip':
            case 'rar':
                return 'fas fa-file-archive';
            default:
                return 'fas fa-file';
        }
    }

    //Helper method to format file size
    public function getFormattedFileSize()
    {
        if (!$this->file_size) return null;

        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            $size = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $size = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $size = number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
