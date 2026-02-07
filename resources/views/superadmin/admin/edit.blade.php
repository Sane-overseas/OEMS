@extends('layouts.superadmin')

@section('title', 'Edit Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 pb-10">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 py-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Admin</h2>
            <p class="text-sm text-gray-500">Update details for {{ $admin->name }}</p>
        </div>
        <a href="{{ route('superadmin.admins.index') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to List
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded p-4">
        <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('superadmin.admins.update', $admin->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Basic Information -->
            <div class="w-full lg:w-2/3 space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="mb-5 border-b pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="inline-block bg-blue-100 text-blue-600 p-2 rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A9.004 9.004 0 0112 15a9.004 9.004 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <h3 class="font-semibold text-gray-800">Basic Information</h3>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Full Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Email Address <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Mobile Number</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $admin->mobile) }}"
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" placeholder="Leave blank to keep current"
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Role & Permissions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="mb-5 border-b pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="inline-block bg-blue-100 text-blue-600 p-2 rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c0-2.21 3-4 3-4s3 1.79 3 4-1.343 2-3 2-3-.895-3-2zm1 8a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </span>
                            <h3 class="font-semibold text-gray-800">Role & Access</h3>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Role <span
                                    class="text-red-500">*</span></label>
                            <select name="role" required
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <option value="school_admin" {{ old('role', $admin->role) == 'school_admin' ? 'selected'
                                    : '' }}>School Admin</option>
                                <option value="sub_admin" {{ old('role', $admin->role) == 'sub_admin' ? 'selected' : ''
                                    }}>Sub Admin</option>
                                <option value="staff" {{ old('role', $admin->role) == 'staff' ? 'selected' : '' }}>Staff
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Assign School</label>
                            <select name="school_id"
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <option value="">Global (No School)</option>
                                @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id', $admin->school_id) == $school->id
                                    ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->code }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Account Status</label>
                            <select name="status"
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <option value="active" {{ old('status', $admin->status) == 'active' ? 'selected' : ''
                                    }}>Active</option>
                                <option value="pending" {{ old('status', $admin->status) == 'pending' ? 'selected' : ''
                                    }}>Pending</option>
                                <option value="blocked" {{ old('status', $admin->status) == 'blocked' ? 'selected' : ''
                                    }}>Blocked</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Login Method</label>
                            <select name="login_method"
                                class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <option value="password" {{ old('login_method', $admin->login_method) == 'password' ?
                                    'selected' : '' }}>Password</option>
                                <option value="otp" {{ old('login_method', $admin->login_method) == 'otp' ? 'selected' :
                                    '' }}>OTP Only</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Settings -->
            <div class="w-full lg:w-1/3 space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="mb-5 border-b pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="inline-block bg-blue-100 text-blue-600 p-2 rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17l.75 1.25 5.75-9.5" />
                                </svg>
                            </span>
                            <h3 class="font-semibold text-gray-800">Settings</h3>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <div class="flex items-center">
                            <input type="checkbox" name="two_factor" value="1" id="twoFactor"
                                class="form-checkbox h-5 w-5 text-blue-600 transition" {{ old('two_factor',
                                $admin->two_factor) ? 'checked' : '' }}>
                            <label for="twoFactor" class="ml-3 font-medium text-gray-700 select-none">
                                Enable Two-Factor Auth
                            </label>
                        </div>
                        <div class="flex flex-col gap-2 pt-2">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded shadow font-semibold transition">
                                Update Admin
                            </button>
                            <a href="{{ route('superadmin.admins.index') }}"
                                class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded border border-gray-200 transition font-medium">
                                Cancel
                            </a>
                        </div>
                        <div class="pt-4 text-center">
                            <button type="button"
                                class="inline-flex items-center px-3 py-1.5 text-sm text-red-700 border border-red-200 rounded hover:bg-red-50 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a2 2 0 012 2v2H7V5a2 2 0 012-2z" />
                                </svg>
                                Delete Admin Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection