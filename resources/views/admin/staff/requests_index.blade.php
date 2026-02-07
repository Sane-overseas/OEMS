@extends('layouts.admin')

@section('title', 'Sent Requests')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-lg shadow border border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-2h6a2 2 0 012 2v12a2 2 0 01-2 2z"></path></svg>
                <h2 class="text-lg sm:text-xl font-semibold text-indigo-800">Sent Staff Requests</h2>
            </div>
            <a href="{{ route('admin.requests.staff.create') }}" class="inline-flex items-center px-4 py-2 mt-3 sm:mt-0 text-sm font-medium rounded bg-indigo-600 text-white hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                New Request
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Target Staff</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Request Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($requests as $request)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                @if($request->targetUser)
                                    <div class="font-semibold text-gray-800">{{ $request->targetUser->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->targetUser->email }}</div>
                                @else
                                    <span class="text-gray-400 italic">Unknown User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($request->request_type == 'block_user')
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">Block User</span>
                                @elseif($request->request_type == 'unblock_user')
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">Unblock User</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700 font-semibold">{{ str_replace('_', ' ', ucfirst($request->request_type)) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <span class="block truncate" title="{{ $request->reason }}">
                                    {{ $request->reason }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($request->status == 'pending')
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-semibold">Pending</span>
                                @elseif($request->status == 'approved')
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">Approved</span>
                                @elseif($request->status == 'rejected')
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">Rejected</span>
                                    @if($request->rejection_reason)
                                        <span class="ml-2 inline-block align-middle text-gray-400" title="{{ $request->rejection_reason }}">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" />
                                                <line x1="12" y1="16" x2="12" y2="12" />
                                                <line x1="12" y1="8" x2="12.01" y2="8" />
                                            </svg>
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700 font-semibold">{{ ucfirst($request->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $request->created_at->format('M d, Y h:i A') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-400">
                                No requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $requests->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
