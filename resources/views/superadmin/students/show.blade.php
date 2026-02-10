@extends('layouts.superadmin')

@section('title', 'Student Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Profile & Basic Info -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
            <div class="relative inline-block">
                @if($student->photo)
                    <img class="h-32 w-32 rounded-full object-cover mx-auto border-4 border-gray-100" src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}">
                @else
                    <div class="h-32 w-32 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-gray-400 text-4xl border-4 border-gray-50">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
                <span class="absolute bottom-2 right-2 w-5 h-5 rounded-full border-2 border-white {{ $student->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
            </div>
            
            <h3 class="mt-4 text-xl font-bold text-gray-800">{{ $student->name }}</h3>
            <p class="text-gray-500 text-sm">{{ $student->email }}</p>
            
            <div class="mt-6 flex justify-center space-x-3">
                <form action="{{ route('superadmin.students.toggle-status', $student->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $student->status === 'active' ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                        {{ $student->status === 'active' ? 'Block Student' : 'Unblock Student' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Contact Information</h4>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between">
                    <span class="text-gray-500">Phone:</span>
                    <span class="font-medium text-gray-800">{{ $student->phone_number ?? 'N/A' }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-500">Aadhar:</span>
                    <span class="font-medium text-gray-800">{{ $student->aadhar_number ?? 'N/A' }}</span>
                </li>
                <li class="flex flex-col mt-2">
                    <span class="text-gray-500 mb-1">Address:</span>
                    <span class="font-medium text-gray-800">{{ $student->address ?? 'N/A' }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Column: Academic & Actions -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Academic Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Academic Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs text-gray-500 uppercase">School</label>
                    <div class="mt-1 text-base font-medium text-gray-900">{{ $student->school->name ?? 'No School Assigned' }}</div>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Admission Number</label>
                    <div class="mt-1 text-base font-medium text-gray-900">{{ $student->admission_number ?? '-' }}</div>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Grade / Class</label>
                    <div class="mt-1 text-base font-medium text-gray-900">{{ $student->grade ?? '-' }}</div>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Section</label>
                    <div class="mt-1 text-base font-medium text-gray-900">{{ $student->section ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Administrative Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Administrative Actions</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Transfer School -->
                <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
                    <h5 class="font-semibold text-gray-700 mb-2">Transfer School</h5>
                    <p class="text-xs text-gray-500 mb-4">Move this student to another school. This will update their school ID.</p>
                    
                    <form action="{{ route('superadmin.students.transfer', $student->id) }}" method="POST">
                        @csrf
                        <div class="flex gap-2">
                            <select name="school_id" required class="flex-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select Target School</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-md text-sm hover:bg-blue-700">Transfer</button>
                        </div>
                    </form>
                </div>

                <!-- Reset Exam Attempt -->
                <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
                    <h5 class="font-semibold text-gray-700 mb-2">Reset Exam Attempt</h5>
                    <p class="text-xs text-gray-500 mb-4">Clear a student's attempt for a specific exam, allowing them to retake it.</p>
                    
                    <form action="{{ route('superadmin.students.reset-exam', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the student\'s answers for this exam.');">
                        @csrf
                        <div class="flex gap-2">
                            <select name="exam_id" required class="flex-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-orange-500 text-white px-3 py-2 rounded-md text-sm hover:bg-orange-600">Reset</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- Recent Activity (Placeholder) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activity</h3>
            <div class="text-sm text-gray-500 italic">No recent activity logs found for this student.</div>
        </div>

    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
    {{ session('error') }}
</div>
@endif
@endsection
