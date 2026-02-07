@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h4 class="text-2xl font-bold text-blue-600 mb-1">School Overview</h4>
        <span class="text-gray-500 text-sm">Welcome back! Here's a quick summary of your school's activity.</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <!-- Total Students -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 text-center p-6">
            <div class="flex justify-center mb-3">
                <i class="bi bi-people text-4xl text-green-600"></i>
            </div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Total Students</h5>
            <h2 class="text-3xl font-bold text-gray-900">@yield('total_students', '382')</h2>
        </div>
        <!-- Upcoming Exams -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 text-center p-6">
            <div class="flex justify-center mb-3">
                <i class="bi bi-calendar-event text-4xl text-blue-600"></i>
            </div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Upcoming Exams</h5>
            <h2 class="text-3xl font-bold text-gray-900">@yield('upcoming_exams', '3')</h2>
        </div>
        <!-- Live Exams -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 text-center p-6">
            <div class="flex justify-center mb-3">
                <i class="bi bi-camera-video text-4xl text-red-600"></i>
            </div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Live Exams</h5>
            <h2 class="text-3xl font-bold text-gray-900">@yield('live_exams', '1')</h2>
        </div>
        <!-- Pending Evaluations -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 text-center p-6">
            <div class="flex justify-center mb-3">
                <i class="bi bi-hourglass-split text-4xl text-yellow-600"></i>
            </div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Pending Evaluations</h5>
            <h2 class="text-3xl font-bold text-gray-900">@yield('pending_evaluations', '6')</h2>
        </div>
        <!-- Violation Alerts -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 text-center p-6">
            <div class="flex justify-center mb-3">
                <i class="bi bi-exclamation-octagon text-4xl text-red-600"></i>
            </div>
            <h5 class="text-sm font-medium text-gray-700 mb-2">Violation Alerts</h5>
            <h2 class="text-3xl font-bold text-gray-900">@yield('violation_alerts', '2')</h2>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-white">
            <h6 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-clock-history text-gray-600"></i>
                Recent Activity
            </h6>
        </div>
        <div class="p-6">
            <p class="text-gray-500">No recent activities to display.</p>
        </div>
    </div>
</div>
@endsection