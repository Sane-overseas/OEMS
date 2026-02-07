@extends('layouts.admin')

@section('title', 'Edit Student')

@section('content')
<div class="flex justify-center w-full bg-gray-50 py-10 min-h-screen">
    <div class="w-full max-w-3xl">
        <div class="bg-white shadow-lg rounded-md">
            <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i>
                    Edit Student
                </h2>
                <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 text-gray-700 transition-colors">
                    <i class="bi bi-arrow-left mr-2"></i>
                    Back to Students List
                </a>
            </div>
            <div class="p-8">
                
                @if(session('success'))
                    <div class="mb-6 flex items-center p-4 rounded bg-green-100 text-green-800 relative">
                        <span class="flex-1">{{ session('success') }}</span>
                        <button type="button" class="ml-4 text-green-700 focus:outline-none" onclick="this.parentElement.style.display='none'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 flex items-center p-4 rounded bg-red-100 text-red-800 relative">
                        <span class="flex-1">{{ session('error') }}</span>
                        <button type="button" class="ml-4 text-red-700 focus:outline-none" onclick="this.parentElement.style.display='none'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <section>
                        <h3 class="text-lg font-bold text-gray-600 mb-4">Account Information</h3>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="flex-1">
                                <label for="name" class="block font-medium text-sm text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('name') border-red-500 @enderror"
                                    autocomplete="off">
                                @error('name')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="email" class="block font-medium text-sm text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" required
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('email') border-red-500 @enderror"
                                    autocomplete="off">
                                @error('email')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6 mt-6">
                            <div class="flex-1">
                                <label for="status" class="block font-medium text-sm text-gray-700 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" required
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6 mt-6">
                            <div class="flex-1">
                                <label for="password" class="block font-medium text-sm text-gray-700 mb-1">
                                    Password <small class="text-gray-500">(Leave blank to keep current)</small>
                                </label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('password') border-red-500 @enderror"
                                    autocomplete="new-password">
                                @error('password')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700 mb-1">
                                    Confirm Password
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                    autocomplete="new-password">
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3 class="text-lg font-bold text-gray-600 mb-4">Personal Details</h3>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="flex-1">
                                <label for="phone_number" class="block font-medium text-sm text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}" required
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('phone_number') border-red-500 @enderror"
                                    autocomplete="off">
                                @error('phone_number')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="aadhar_number" class="block font-medium text-sm text-gray-700 mb-1">
                                    Aadhar Number
                                </label>
                                <input type="text" id="aadhar_number" name="aadhar_number" value="{{ old('aadhar_number', $student->aadhar_number) }}"
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('aadhar_number') border-red-500 @enderror"
                                    autocomplete="off">
                                @error('aadhar_number')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="address" class="block font-medium text-sm text-gray-700 mb-1">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address" rows="2" required
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('address') border-red-500 @enderror">{{ old('address', $student->address) }}</textarea>
                            @error('address')
                            <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-6 flex flex-col md:flex-row gap-6">
                            <div class="flex-1">
                                <label for="photo" class="block font-medium text-sm text-gray-700 mb-1">
                                    Student Photo
                                </label>
                                <input type="file" id="photo" name="photo" accept="image/*"
                                    class="block w-full text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 shadow-sm @error('photo') border-red-500 @enderror">
                                @if($student->photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $student->photo) }}" alt="Current Photo" class="h-20 w-20 object-cover rounded border border-gray-300">
                                    </div>
                                @endif
                                @error('photo')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section>
                        <h3 class="text-lg font-bold text-gray-600 mb-4">Academic Details</h3>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="flex-1">
                                <label for="admission_number" class="block font-medium text-sm text-gray-700 mb-1">
                                    Admission Number
                                </label>
                                <input type="text" id="admission_number" name="admission_number" value="{{ old('admission_number', $student->admission_number) }}"
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('admission_number') border-red-500 @enderror"
                                    autocomplete="off">
                                @error('admission_number')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="grade" class="block font-medium text-sm text-gray-700 mb-1">
                                    Grade / Class
                                </label>
                                <input type="text" id="grade" name="grade" value="{{ old('grade', $student->grade) }}" placeholder="e.g. 10th"
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('grade') border-red-500 @enderror"
                                    autocomplete="off">
                                @error('grade')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="section" class="block font-medium text-sm text-gray-700 mb-1">
                                    Section
                                </label>
                                <input type="text" id="section" name="section" value="{{ old('section', $student->section) }}" placeholder="e.g. A"
                                    class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('section') border-red-500 @enderror"
                                    autocomplete="off">
                                @error('section')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <div class="flex justify-end gap-4 pt-8">
                        <a href="{{ route('admin.students.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded hover:bg-gray-200 border border-gray-300 transition-colors">
                            Back
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 shadow transition-colors flex items-center gap-2">
                            <i class="bi bi-save"></i>
                            Update Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
