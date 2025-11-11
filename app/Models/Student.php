<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'date_of_birth',
        'address',
        'emergency_contact',
        'parent_guardian',
        'medical_info',
        'profile_picture',
        'grade_level',
        'section',
        'academic_year',
        'homeroom_teacher',
        'subjects',
        'enrollment_date',
        'gpa',
        'attendance_rate',
        'completed_assignments',
        'total_assignments',
        'class_rank',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
        'gpa' => 'float', // Change to float instead of decimal
        'attendance_rate' => 'integer',
        'completed_assignments' => 'integer',
        'total_assignments' => 'integer',
        'class_rank' => 'integer',
    ];

    /**
     * Get the user that owns the student profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the student's full name through user relationship.
     */
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get the student's email through user relationship.
     */
    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    /**
     * Get the student's phone number through user relationship.
     */
    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }
}