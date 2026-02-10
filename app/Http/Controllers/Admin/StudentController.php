<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')
            ->where('school_id', auth('admin')->user()->school_id)
            ->latest()
            ->paginate(10);

        return view('admin.students.index', compact('students'));
    }
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'admission_number' => ['nullable', 'string', 'max:50'],
            'grade' => ['nullable', 'string', 'max:50'],
            'section' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'max:20'],
            'aadhar_number' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students/photos', 'public');
        }

        // Create the User account with student details
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'photo' => $photoPath,
            'phone_number' => $validated['phone_number'],
            'aadhar_number' => $validated['aadhar_number'],
            'address' => $validated['address'],
            'role' => 'student',
            'school_id' => auth('admin')->user()->school_id,
            'status' => 'active',
            'admission_number' => $validated['admission_number'],
            'grade' => $validated['grade'],
            'section' => $validated['section'],
        ]);

        return redirect()->route('admin.students.create')->with('success', 'Student added successfully.');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(string $id)
    {
        $student = User::where('role', 'student')
            ->where('school_id', auth('admin')->user()->school_id)
            ->findOrFail($id);

        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = User::where('role', 'student')
            ->where('school_id', auth('admin')->user()->school_id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $student->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'admission_number' => ['nullable', 'string', 'max:50'],
            'grade' => ['nullable', 'string', 'max:50'],
            'section' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
            'phone_number' => ['required', 'string', 'max:20'],
            'aadhar_number' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'admission_number' => $validated['admission_number'],
            'grade' => $validated['grade'],
            'section' => $validated['section'],
            'status' => $validated['status'],
            'phone_number' => $validated['phone_number'],
            'aadhar_number' => $validated['aadhar_number'],
            'address' => $validated['address'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        $student->update($data);

        return redirect()->route('admin.students.edit', $student->id)->with('success', 'Student updated successfully.');
    }
}