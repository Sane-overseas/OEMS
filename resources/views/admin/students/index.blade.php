@extends('layouts.admin')

@section('title', 'View Students')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between px-6 py-4 border-b border-gray-100 gap-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M17 20a4 4 0 00-8 0m8 0H7m8 0V8a4 4 0 10-8 0v12"/>
                    </svg>
                    <h2 class="text-xl font-bold text-blue-700">Students List</h2>
                </div>
                <span class="ml-2 inline-block rounded-full bg-blue-100 text-blue-700 text-base px-4 py-1 font-medium">
                    {{ $students->total() }} Students
                </span>
            </div>
            <div class="flex gap-2 flex-wrap items-center mt-2 md:mt-0">
                <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition">
                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 7v10M7 17V7" /></svg>
                    Sign Up Link
                </a>
                <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition">
                    <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v16h16V4H4zm8 14a6 6 0 100-12 6 6 0 000 12z" /></svg>
                    Bulk Upload
                </a>
                <a href="{{ route('admin.students.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-1 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                    Add Student
                </a>
            </div>
        </div>
        <div class="px-6 pt-5">
            {{-- Filter or Search --}}
            <form method="GET" action="" class="flex flex-col sm:flex-row sm:items-end gap-3 w-full mb-1" autocomplete="off">
                <div class="w-full sm:w-auto" style="max-width: 300px;">
                    <label for="search" class="block text-xs font-semibold text-gray-500 mb-1">Search by Name/Email</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-base text-gray-700 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition"
                        placeholder="Search student">
                </div>
                <div class="flex gap-2">
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium rounded bg-white border border-blue-500 text-blue-700 hover:bg-blue-50 hover:text-blue-800 transition" type="submit">
                        <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Search
                    </button>
                    <a href="{{ route('admin.students.index') }}"
                       class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-800 px-2 py-2">
                        Reset
                    </a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-gray-900">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="pl-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Name</th>
                        <th class="py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Admission No</th>
                        <th class="py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Grade</th>
                        <th class="py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Section</th>
                        <th class="py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                        <th class="pr-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($students as $student)
                    <tr>
                        <td class="pl-6 py-4">
                            <div class="flex items-center">
                                @if($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}"
                                        alt=""
                                        class="w-11 h-11 rounded-full object-cover shadow mr-3 ring-2 ring-offset-1 ring-blue-400">
                                @else
                                    <div class="flex items-center justify-center w-11 h-11 rounded-full bg-blue-500 text-white font-bold text-lg mr-3 shadow ring-2 ring-offset-1 ring-blue-300">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-semibold text-gray-900 text-base">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M16 7v.01"/><rect width="18" height="14" x="3" y="5" rx="2"/><path d="M3 7l9 6 9-6"/>
                                        </svg>
                                        {{ $student->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            @if($student->admission_number)
                                <span class="inline-block rounded bg-cyan-100 text-cyan-800 text-xs px-2 py-1 font-semibold border border-cyan-300">
                                    {{ $student->admission_number }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-4">
                            @if($student->grade)
                                <span class="inline-block rounded bg-green-100 text-green-800 text-xs px-2 py-1 font-semibold border border-green-200">
                                    {{ $student->grade }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-4">
                            @if($student->section)
                                <span class="inline-block rounded bg-gray-100 text-gray-800 text-xs px-2 py-1 font-semibold border border-gray-300">
                                    {{ $student->section }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-4">
                            @if($student->status === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 border border-green-300 font-semibold text-xs">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Active
                                </span>
                            @elseif($student->status === 'inactive')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 border border-red-300 font-semibold text-xs">
                                    <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Inactive
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-300 font-semibold text-xs">
                                    {{ ucfirst($student->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="pr-6 py-4 text-right">
                            <a href="{{ route('admin.students.edit', $student->id) }}"
                               class="inline-flex items-center px-2 py-1 text-blue-600 hover:text-white hover:bg-blue-600 rounded border border-blue-200 transition"
                               title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M3 17.25V21h3.75l11.06-11.06a2.121 2.121 0 10-3-3L3 17.25z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-400">
                                <div class="flex flex-col items-center justify-center py-6">
                                    <svg class="w-14 h-14 mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M8 10h.01M16 10h.01M7 16c1.333-1.333 4.667-1.333 6 0"/>
                                    </svg>
                                    <div class="text-lg font-medium">No students found.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
            <div class="px-6 py-4 border-t bg-white rounded-b-lg">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="text-gray-500 text-sm">
                        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students
                    </div>
                    <div>
                        {{ $students->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
