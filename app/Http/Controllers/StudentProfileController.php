<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentProfileController extends Controller
{
    /**
     * Display the student profile page.
     */
    public function show()
    {
        $user = Auth::user();
        $student = $user->student;
        
        // If student profile doesn't exist, create a basic one
        if (!$student) {
            $student = $this->createStudentProfile($user);
        }
        
        // Add sample performance data for demonstration
        $student = $this->addSamplePerformanceData($student);
        
        return view('student.student-profile', compact('student'));
    }

    /**
     * Update the student's profile information.
     */
     public function updatePersonal(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:255',
            'parent_guardian' => 'nullable|string|max:255',
            'medical_info' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update user information
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Update student personal information
            $student->update([
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'emergency_contact' => $request->emergency_contact,
                'parent_guardian' => $request->parent_guardian,
                'medical_info' => $request->medical_info,
            ]);

            return redirect()->back()->with('success', 'Personal information updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update personal information: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the student's academic information.
     */
    public function updateAcademic(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $validator = Validator::make($request->all(), [
            'grade_level' => 'nullable|string|max:50',
            'section' => 'nullable|string|max:50',
            'academic_year' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update student academic information only
            $student->update([
                'grade_level' => $request->grade_level,
                'section' => $request->section,
                'academic_year' => $request->academic_year,
            ]);

            return redirect()->back()->with('success', 'Academic information updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update academic information: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the student's password.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect.')
                ->withInput();
        }

        try {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Password updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update password: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the student's profile picture.
     */
    public function updatePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Invalid image file. Please upload a JPEG, PNG, or GIF image under 2MB.');
        }

        try {
            $user = Auth::user();
            $student = $user->student;

            // Delete old profile picture if exists
            if ($student->profile_picture) {
                Storage::delete('public/profile-pictures/' . $student->profile_picture);
            }

            // Store new profile picture
            $imageName = 'student_' . $student->id . '_' . time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->storeAs('public/profile-pictures', $imageName);

            // Update student record
            $student->update([
                'profile_picture' => $imageName,
            ]);

            return redirect()->back()->with('success', 'Profile picture updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update profile picture: ' . $e->getMessage());
        }
    }

    /**
     * Remove the student's profile picture.
     */
    public function removePicture()
    {
        try {
            $user = Auth::user();
            $student = $user->student;

            if ($student->profile_picture) {
                Storage::delete('public/profile-pictures/' . $student->profile_picture);
                
                $student->update([
                    'profile_picture' => null,
                ]);

                return redirect()->back()->with('success', 'Profile picture removed successfully!');
            }

            return redirect()->back()->with('error', 'No profile picture to remove.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to remove profile picture: ' . $e->getMessage());
        }
    }

    /**
     * Create a student profile if it doesn't exist.
     */
    private function createStudentProfile(User $user)
    {
        return Student::create([
            'user_id' => $user->id,
            'student_id' => 'STU-' . date('Y') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'grade_level' => 'Grade 10',
            'section' => 'A',
            'academic_year' => date('Y') . '-' . (date('Y') + 1),
            'enrollment_date' => now(),
            'gpa' => '0.00', // Store as string to match decimal format
            'attendance_rate' => 0,
            'completed_assignments' => 0,
            'total_assignments' => 0,
        ]);
    }

    /**
     * Add sample performance data for demonstration.
     */
    private function addSamplePerformanceData(Student $student)
    {
        // Add dynamic properties for the view
        $student->subjects_performance = [
            [
                'name' => 'Mathematics',
                'teacher' => 'Mr. Smith',
                'grade' => 'A',
                'grade_color' => 'success',
                'progress' => 85,
                'progress_color' => 'success',
                'status' => 'Excellent',
                'status_color' => 'success'
            ],
            [
                'name' => 'Science',
                'teacher' => 'Ms. Johnson',
                'grade' => 'B+',
                'grade_color' => 'info',
                'progress' => 78,
                'progress_color' => 'info',
                'status' => 'Good',
                'status_color' => 'info'
            ],
            [
                'name' => 'English',
                'teacher' => 'Mrs. Davis',
                'grade' => 'A-',
                'grade_color' => 'success',
                'progress' => 82,
                'progress_color' => 'success',
                'status' => 'Very Good',
                'status_color' => 'success'
            ],
            [
                'name' => 'History',
                'teacher' => 'Mr. Wilson',
                'grade' => 'B',
                'grade_color' => 'info',
                'progress' => 75,
                'progress_color' => 'info',
                'status' => 'Good',
                'status_color' => 'info'
            ],
            [
                'name' => 'Art',
                'teacher' => 'Ms. Thompson',
                'grade' => 'A',
                'grade_color' => 'success',
                'progress' => 90,
                'progress_color' => 'success',
                'status' => 'Excellent',
                'status_color' => 'success'
            ]
        ];

        $student->recent_grades = [
            [
                'assessment' => 'Algebra Test',
                'subject' => 'Mathematics',
                'date' => now()->subDays(5)->format('Y-m-d'),
                'score' => '92%',
                'score_color' => 'success',
                'weight' => '15%'
            ],
            [
                'assessment' => 'Chemistry Lab',
                'subject' => 'Science',
                'date' => now()->subDays(8)->format('Y-m-d'),
                'score' => '85%',
                'score_color' => 'info',
                'weight' => '10%'
            ],
            [
                'assessment' => 'Essay Assignment',
                'subject' => 'English',
                'date' => now()->subDays(10)->format('Y-m-d'),
                'score' => '88%',
                'score_color' => 'success',
                'weight' => '20%'
            ],
        ];

        // Set sample GPA and attendance if not set
        // Use string comparison for decimal fields
        if (!$student->gpa || $student->gpa === '0.00') {
            $student->gpa = '3.75'; // Store as string
        }
        
        if (!$student->attendance_rate || $student->attendance_rate == 0) {
            $student->attendance_rate = 92;
        }
        
        if (!$student->class_rank) {
            $student->class_rank = 15;
        }

        return $student;
    }
}