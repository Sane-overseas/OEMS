@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg text-white p-6 col-span-1 md:col-span-3">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100">You have <span class="font-bold text-white">{{ $upcomingExams->count() }}</span> upcoming exams available.</p>
            </div>
            <div class="hidden md:block opacity-80">
                <i class="bi bi-mortarboard text-6xl"></i>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-1">Upcoming Exams</div>
        <div class="text-3xl font-bold text-gray-800">{{ $upcomingExams->count() }}</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-1">Completed Exams</div>
        <div class="text-3xl font-bold text-gray-800">0</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-1">Average Score</div>
        <div class="text-3xl font-bold text-green-600">0%</div>
    </div>
</div>

<!-- Upcoming Exams List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Available Exams</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 font-medium border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3">Exam Title</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Duration</th>
                    <th class="px-6 py-3">Total Marks</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($upcomingExams as $exam)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $exam->title }}</td>
                    <td class="px-6 py-4">{{ $exam->subject }}</td>
                    <td class="px-6 py-4">{{ $exam->duration_minutes }} mins</td>
                    <td class="px-6 py-4">{{ $exam->total_marks }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition">Start Exam</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        No upcoming exams found for your class.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
