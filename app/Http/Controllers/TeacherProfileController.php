<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TeacherProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $teacher = Auth::user();
        return view('teacher.teacher-profile', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Debug: Check what data is being submitted
        \Log::info('Profile update request data:', $request->all());

        $teacher = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($teacher->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'department' => ['nullable', 'string', 'max:255'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
            'address' => ['nullable', 'string', 'max:500'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
        ]);

        // Debug: Check validated data
        \Log::info('Validated data:', $validated);
    }

    /**
     * Update profile picture only
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $teacher = Auth::user();

        try {
            // Delete old profile picture if exists
            if ($teacher->profile_picture && Storage::exists('public/profile-pictures/' . $teacher->profile_picture)) {
                Storage::delete('public/profile-pictures/' . $teacher->profile_picture);
            }

            // Store new profile picture
            $imagePath = $request->file('profile_picture')->store('profile-pictures', 'public');
            $teacher->update(['profile_picture' => basename($imagePath)]);

            return redirect()->route('teacher.teacher-profile')->with('success', 'Profile picture updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('teacher.teacher-profile')->with('error', 'Failed to update profile picture: ' . $e->getMessage());
        }
    }

    /**
     * Remove profile picture
     */
    public function removeProfilePicture()
    {
        $teacher = Auth::user();

        try {
            if ($teacher->profile_picture && Storage::exists('public/profile-pictures/' . $teacher->profile_picture)) {
                Storage::delete('public/profile-pictures/' . $teacher->profile_picture);
            }

            $teacher->update(['profile_picture' => null]);

            return redirect()->route('teacher.teacher-profile')->with('success', 'Profile picture removed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('teacher.teacher-profile')->with('error', 'Failed to remove profile picture: ' . $e->getMessage());
        }
    }

    /**
     * Update professional information
     */
    public function updateProfessional(Request $request)
    {
        $teacher = Auth::user();

        $validated = $request->validate([
            'employee_id' => ['nullable', 'string', 'max:50'],
            'join_date' => ['nullable', 'date'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'subjects' => ['nullable', 'string', 'max:500'],
            'classes_assigned' => ['nullable', 'string', 'max:500'],
            'work_schedule' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            // Format join_date if provided
            if ($request->join_date) {
                $validated['join_date'] = Carbon::parse($request->join_date)->format('Y-m-d');
            }

            $teacher->update($validated);

            return redirect()->route('teacher.teacher-profile')->with('success', 'Professional information updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('teacher.teacher-profile')->with('error', 'Failed to update professional information: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('teacher.teacher-profile')->with('success', 'Password updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
