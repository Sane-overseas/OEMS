@extends('layouts.superadmin')

@section('title', 'Staff Approval Queue')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
            <h4 class="text-2xl font-bold text-gray-800 mb-1">Staff Approval Queue</h4>
            <p class="text-sm text-gray-500">Review new staff and admin account requests</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 flex items-center bg-green-100 text-green-800 px-4 py-3 rounded relative" role="alert">
            <span class="flex-1">{{ session('success') }}</span>
            <button type="button" class="ml-2 text-green-500 hover:text-green-700 focus:outline-none" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M6.225 4.811a1 1 0 1 0-1.414 1.414L8.586 10l-3.775 3.775a1 1 0 1 0 1.414 1.414L10 11.414l3.775 3.775a1 1 0 1 0 1.414-1.414L11.414 10l3.775-3.775a1 1 0 0 0-1.414-1.414L10 8.586 6.225 4.811z"/></svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 flex items-center bg-red-100 text-red-800 px-4 py-3 rounded relative" role="alert">
            <span class="flex-1">{{ session('error') }}</span>
            <button type="button" class="ml-2 text-red-500 hover:text-red-700 focus:outline-none" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M6.225 4.811a1 1 0 1 0-1.414 1.414L8.586 10l-3.775 3.775a1 1 0 1 0 1.414 1.414L10 11.414l3.775 3.775a1 1 0 1 0 1.414-1.414L11.414 10l3.775-3.775a1 1 0 0 0-1.414-1.414L10 8.586 6.225 4.811z"/></svg>
            </button>
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested At</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($pendingRequests as $request)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($request->photo)
                                        <img src="{{ asset('storage/' . $request->photo) }}" alt="{{ $request->name }}" class="rounded-full mr-3 object-cover" style="width:40px;height:40px;">
                                    @else
                                        <div class="flex-shrink-0 mr-3 w-10 h-10 bg-gray-300 rounded-full text-gray-700 flex items-center justify-center font-bold text-lg uppercase">
                                            {{ strtoupper(substr($request->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $request->name }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $request->staff_type ? ucwords(str_replace('_', ' ', $request->staff_type)) : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $request->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $request->school->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="capitalize bg-blue-50 text-blue-700 px-2 py-1 text-xs rounded">
                                    {{ str_replace('_', ' ', $request->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $request->requester->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $request->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('superadmin.staff-requests.show', $request) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded bg-blue-600 hover:bg-blue-700 text-white transition"
                                   title="Review">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4m5 2a9 9 0 11-18 0a9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="text-lg font-medium">All caught up! There are no pending staff requests.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pendingRequests->hasPages())
            <div class="bg-white px-4 py-4 border-t border-gray-100">
                {{ $pendingRequests->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
