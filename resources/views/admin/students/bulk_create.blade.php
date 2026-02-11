@extends('layouts.admin')

@section('title', 'Bulk Upload Students')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white shadow-xl rounded-lg border border-gray-300">
        <div class="flex flex-wrap justify-between items-center border-b px-10 py-6 bg-white rounded-t-lg">
            <h2 class="text-2xl font-bold text-blue-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l3 3 3-3M12 15V3"/>
                </svg>
                Bulk Upload Students
            </h2>
            <a href="{{ route('admin.students.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-400 text-gray-700 rounded-md hover:bg-gray-100 transition text-base font-medium shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to List
            </a>
        </div>
        <div class="px-10 py-10">

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 rounded-lg px-5 py-4 mb-7 relative shadow-sm">
                    <span>{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()"
                            class="absolute top-2 right-3 text-xl text-red-500 hover:text-red-700 transition-colors">&times;</button>
                </div>
            @endif

            <div class="bg-blue-50 border border-blue-200 rounded-lg px-7 py-5 mb-8 shadow-sm">
                <div class="flex items-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20C6.477 20 2 15.523 2 10S6.477 0 12 0s10 4.477 10 10-4.477 10-10 10z" />
                    </svg>
                    <span class="font-semibold text-blue-700 text-lg">CSV Format Instructions</span>
                </div>
                <p class="mb-3 text-gray-700 text-base">Please upload a CSV file with the first row as headers. The columns should be in the following order:</p>
                <ol class="ml-7 list-decimal text-gray-900 text-base space-y-1">
                    <li><span class="font-semibold">Name</span> (Required)</li>
                    <li><span class="font-semibold">Email</span> (Required, Unique)</li>
                    <li><span class="font-semibold">Password</span> (Required)</li>
                    <li><span class="font-semibold">Phone Number</span> (Required)</li>
                    <li><span class="font-semibold">Address</span> (Required)</li>
                    <li><span class="font-semibold">Admission Number</span> (Optional)</li>
                    <li><span class="font-semibold">Grade</span> (Optional)</li>
                    <li><span class="font-semibold">Section</span> (Optional)</li>
                    <li><span class="font-semibold">Aadhar Number</span> (Optional)</li>
                </ol>
            </div>

            <div class="flex gap-4 mb-8">
                <a href="{{ route('admin.students.bulk_sample') }}"
                   class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 text-base font-semibold shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3m0 4v6M13 5l7 7-7 7"/>
                    </svg>
                    Download Sample CSV
                </a>
                <a href="{{ route('admin.students.bulk_sample') }}"
                   class="inline-flex items-center px-4 py-2 rounded-md border border-green-600 text-green-700 bg-white hover:bg-green-50 text-base font-semibold shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8m0 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2m8-12v6m0 0L9.5 9.5M12 5v6m0 0l2.5-2.5"/>
                    </svg>
                    Download Sample Excel
                </a>
            </div>

            <form action="{{ route('admin.students.bulk_store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div>
                    <label for="file" class="block font-semibold mb-2 text-gray-800 text-base">Select CSV File <span class="text-red-600">*</span></label>
                    <input type="file"
                        id="file"
                        name="file"
                        accept=".csv, .txt"
                        required
                        class="block w-full border border-gray-400 rounded-md shadow-md py-2.5 px-4 text-base text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-400 @error('file') border-red-500 @enderror"
                    >
                    @error('file')
                        <div class="mt-2 text-red-600 text-base">{{ $message }}</div>
                    @enderror
                    <div class="text-sm text-gray-500 mt-2">Max file size: 2MB. Allowed formats: .csv</div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-md bg-blue-700 text-white hover:bg-blue-800 text-base font-semibold shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
