@extends('layouts.superadmin')

@section('title', 'Create School')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Step Indicator -->
    <div class="mb-6">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-600 text-white">Step 1 of 2</span>
        <h4 class="mt-2 text-2xl font-semibold text-gray-800">Create School</h4>
        <p class="text-gray-500">Basic school setup before assigning School Admin</p>
    </div>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.schools.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <!-- School Identity -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-gray-200 font-semibold text-gray-800">🏫 School Identity</div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-12 gap-4">

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">School Name *</label>
                    <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" placeholder="Enter school name" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">School Code *</label>
                    <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror" name="code" value="{{ old('code') }}" placeholder="Ex: SCH-001" required>
                    @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Status</label>
                    <select class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" name="is_active">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">School Type</label>
                    <select class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" name="type">
                        <option value="Government" {{ old('type') == 'Government' ? 'selected' : '' }}>Government</option>
                        <option value="Private" {{ old('type') == 'Private' ? 'selected' : '' }}>Private</option>
                        <option value="Semi-Government" {{ old('type') == 'Semi-Government' ? 'selected' : '' }}>Semi-Government</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Board / Authority</label>
                    <select class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" name="board">
                        <option value="CBSE" {{ old('board') == 'CBSE' ? 'selected' : '' }}>CBSE</option>
                        <option value="ICSE" {{ old('board') == 'ICSE' ? 'selected' : '' }}>ICSE</option>
                        <option value="State Board" {{ old('board') == 'State Board' ? 'selected' : '' }}>State Board</option>
                        <option value="University" {{ old('board') == 'University' ? 'selected' : '' }}>University</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                    <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="registration_no" value="{{ old('registration_no') }}">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Year of Establishment</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="established_year" value="{{ old('established_year') }}">
                </div>

                <div class="md:col-span-12">
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">School Logo</label>
                    <input class="block w-full text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700" type="file" id="logo" name="logo">
                </div>
            </div>
        </div>

        <!-- Address -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-gray-200 font-semibold text-gray-800">📍 Address & Location</div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-12 gap-4">

                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                    <textarea class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="address" rows="2">{{ old('address') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="city" value="{{ old('city') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="state" value="{{ old('state') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">PIN Code</label>
                    <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="pincode" type="text" value="{{ old('pincode') }}">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3">
            <button type="submit" name="action" value="draft" class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">Save as Draft</button>
            <button type="submit" name="action" value="continue" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">Save & Continue</button>
        </div>

    </form>
</div>

@endsection
