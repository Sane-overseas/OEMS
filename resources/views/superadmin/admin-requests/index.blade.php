@extends('layouts.superadmin')

@section('title', ' Block & Unblock Requests')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="border-b px-6 py-4 flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.5304 0 1.0391-.2107 1.4142-.5858C13.7893 10.0391 14 9.5304 14 9s-.2107-1.0391-.5858-1.4142C13.0391 7.2107 12.5304 7 12 7s-1.0391.2107-1.4142.5858C10.2107 7.9609 10 8.4696 10 9s.2107 1.0391.5858 1.4142C10.9609 10.7893 11.4696 11 12 11zm0 4v1" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20H7a2 2 0 01-2-2V7a2 2 0 012-2h2.582a2 2 0 011.414.586l2.828 2.828a2 2 0 001.414.586H17a2 2 0 012 2v7a2 2 0 01-2 2z" />
            </svg>
            <h1 class="text-lg font-bold text-indigo-700">Admin Requests (Reset / Block)</h1>
        </div>
        <div class="px-0 py-0">

            @if(session('success'))
                <div class="mx-6 mt-4 flex items-center bg-green-100 border border-green-200 text-green-800 text-sm px-4 py-3 rounded relative" role="alert">
                    <span class="flex-1">{!! session('success') !!}</span>
                    <button type="button" onclick="this.parentElement.style.display='none'" class="ml-3 text-green-600 hover:text-green-800 focus:outline-none">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4 flex items-center bg-red-100 border border-red-200 text-red-800 text-sm px-4 py-3 rounded relative" role="alert">
                    <span class="flex-1">{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.style.display='none'" class="ml-3 text-red-600 hover:text-red-800 focus:outline-none">&times;</button>
                </div>
            @endif

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b font-semibold text-gray-600">
                        <tr>
                            <th class="pl-6 py-3">School</th>
                            <th class="py-3">Requester</th>
                            <th class="py-3">Target User</th>
                            <th class="py-3">Request Type</th>
                            <th class="py-3">Reason</th>
                            <th class="py-3">Status</th>
                            <th class="pr-6 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="pl-6 py-3">
                                    <span class="font-semibold text-gray-900">{{ $request->school->name ?? 'N/A' }}</span>
                                </td>
                                <td class="py-3">
                                    <div class="text-gray-700">{{ $request->requester->name ?? 'Unknown' }}</div>
                                    <div class="text-gray-400 text-xs">{{ $request->requester->email ?? '' }}</div>
                                </td>
                                <td class="py-3">
                                    @if($request->targetUser)
                                        <div class="font-medium text-gray-900">{{ $request->targetUser->name }}</div>
                                        <div class="text-gray-400 text-xs">{{ $request->targetUser->email }}</div>
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full border text-xs font-medium bg-gray-100 text-gray-700">
                                            {{ ucfirst($request->targetUser->status) }}
                                        </span>
                                    @else
                                        <span class="text-red-500 font-medium">User Not Found</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    @if($request->request_type == 'block_user')
                                        <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-800">
                                            Block User
                                        </span>
                                    @elseif($request->request_type == 'unblock_user')
                                        <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">
                                            Unblock User
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 max-w-xs">
                                    <span class="block truncate" title="{{ $request->reason }}">
                                        {{ $request->reason }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($request->status == 'pending')
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($request->status == 'approved')
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @elseif($request->status == 'rejected')
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="pr-6 py-3 text-right">
                                    @if($request->status == 'pending')
                                        <div class="flex justify-end items-center space-x-2">
                                            <button
                                                class="inline-flex items-center justify-center h-8 w-8 rounded bg-green-500 hover:bg-green-600 text-white focus:outline-none transition"
                                                title="Approve"
                                                onclick="event.preventDefault(); if(confirm('Are you sure you want to approve this request?')) document.getElementById('approve-form-{{ $request->id }}').submit();"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                            <button
                                                class="inline-flex items-center justify-center h-8 w-8 rounded bg-red-500 hover:bg-red-600 text-white focus:outline-none transition"
                                                title="Reject"
                                                onclick="openRejectModal({{ $request->id }})"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <form id="approve-form-{{ $request->id }}" action="{{ route('superadmin.admin-requests.action', $request->id) }}" method="POST" class="hidden">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                        </form>

                                        {{-- Reject Modal --}}
                                        <div
                                            id="rejectModal-{{ $request->id }}"
                                            class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden"
                                        >
                                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md border">
                                                <form action="{{ route('superadmin.admin-requests.action', $request->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="reject">
                                                    <div class="px-6 pt-6 flex items-center justify-between border-b pb-3">
                                                        <h2 class="text-lg font-semibold text-gray-700">Reject Request</h2>
                                                        <button type="button"
                                                            onclick="closeRejectModal({{ $request->id }})"
                                                            class="text-gray-400 hover:text-gray-600 focus:outline-none text-2xl font-bold leading-none">
                                                            &times;
                                                        </button>
                                                    </div>
                                                    <div class="px-6 py-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                                                            <textarea name="rejection_reason" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-200" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="px-6 pb-6 pt-2 flex justify-end space-x-3">
                                                        <button type="button"
                                                            onclick="closeRejectModal({{ $request->id }})"
                                                            class="px-4 py-2 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 transition focus:outline-none">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600 transition focus:outline-none">
                                                            Reject Request
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    @else
                                        <span class="text-gray-400 text-xs">Processed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-400">No requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $requests->links() }}
        </div>
    </div>
</div>

{{-- Tailwind Modal JS --}}
<script>
    function openRejectModal(id) {
        document.getElementById('rejectModal-' + id).classList.remove('hidden');
    }
    function closeRejectModal(id) {
        document.getElementById('rejectModal-' + id).classList.add('hidden');
    }
</script>
@endsection
