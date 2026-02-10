@extends('layouts.admin')

@section('title', 'Add New Staff - Step 3')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-8 px-2">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <h4 class="text-2xl font-bold mb-1 text-gray-800">Add New Staff</h4>
                <p class="text-sm text-gray-500">Step 3: Role & System Access</p>
            </div>
            <div class="px-8 py-8">
                @include('admin.staff.wizard.partials.stepper', ['currentStep' => 3])

                <form method="POST" action="{{ route('admin.staff.create.postStep3') }}" class="space-y-6 mt-6">
                    @csrf
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">System Role</label>
                        <select name="role" id="role" required
                            class="block w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                            <option value="">-- Select Role --</option>
                            @foreach(['staff','sub_admin','invigilator'] as $role)
                            <option value="{{ $role }}"
                                {{ ($data['role'] ?? '') == $role ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_',' ', $role)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="login_method" class="block text-sm font-medium text-gray-700 mb-1">Login Method</label>
                            <select name="login_method" id="login_method" required
                                class="block w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                                <option value="password" {{ (old('login_method', $data['login_method'] ?? 'password') == 'password') ? 'selected' : '' }}>Password Only</option>
                                <option value="otp" {{ (old('login_method', $data['login_method'] ?? '') == 'otp') ? 'selected' : '' }}>Password + OTP</option>
                            </select>
                        </div>
                        <div class="flex items-end pb-2">
                            <div class="flex items-center h-full">
                                <input id="two_factor" name="two_factor" type="checkbox" value="1" {{ (old('two_factor', $data['two_factor'] ?? false)) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="two_factor" class="ml-2 block text-sm text-gray-900">
                                    Enable Two-Factor Auth
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="password" required placeholder="Enter new password"
                                class="block w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirm new password"
                                class="block w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <a href="{{ route('admin.staff.create.step2') }}"
                            class="inline-flex items-center px-5 py-2 bg-transparent border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition">
                            <svg class="h-4 w-4 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                            Next: Review
                            <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection