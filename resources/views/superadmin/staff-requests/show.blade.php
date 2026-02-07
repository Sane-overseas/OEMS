@extends('layouts.superadmin')

@section('title', 'Review Staff Request')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h4 class="text-2xl font-bold text-gray-800 mb-1">Review Staff Request</h4>
            <p class="text-gray-500 text-sm">Review and approve or reject the request for <span class="font-medium">{{ $staffRequest->name }}</span></p>
        </div>
        <a href="{{ route('superadmin.staff-requests.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-md shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
            Back to Queue
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 rounded px-4 py-3 mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Request Details --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="font-semibold">Request Details</span>
                </div>
                <dl class="divide-y divide-gray-100">
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Name</dt>
                        <dd class="flex-1">{{ $staffRequest->name }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Email</dt>
                        <dd class="flex-1">{{ $staffRequest->email }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Mobile</dt>
                        <dd class="flex-1">{{ $staffRequest->mobile }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">School</dt>
                        <dd class="flex-1">{{ $staffRequest->school->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Requested By</dt>
                        <dd class="flex-1">{{ $staffRequest->requester->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Requested At</dt>
                        <dd class="flex-1">{{ $staffRequest->created_at->format('M d, Y h:i A') }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Staff Type</dt>
                        <dd class="flex-1 text-gray-800 capitalize">{{ str_replace('_', ' ', $staffRequest->staff_type) }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Requested Role</dt>
                        <dd class="flex-1 text-gray-800 capitalize">{{ str_replace('_', ' ', $staffRequest->role) }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Aadhaar Details --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M6 21v-2a4 4 0 0 1 4-4c1.657 0 3 .895 3 2v4"></path>
                    </svg>
                    <span class="font-semibold">Aadhaar Details</span>
                </div>
                <dl class="divide-y divide-gray-100">
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Aadhaar Name</dt>
                        <dd class="flex-1">{{ $staffRequest->aadhaar_name ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Aadhaar Number</dt>
                        <dd class="flex-1">{{ $staffRequest->aadhaar_number ? '**** **** ' . substr($staffRequest->aadhaar_number, -4) : 'N/A' }}</dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Aadhaar DOB</dt>
                        <dd class="flex-1">
                            {{ $staffRequest->aadhaar_dob ? \Carbon\Carbon::parse($staffRequest->aadhaar_dob)->format('M d, Y') : 'N/A' }}
                        </dd>
                    </div>
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600">Aadhaar Gender</dt>
                        <dd class="flex-1 capitalize">{{ $staffRequest->aadhaar_gender ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Professional Details --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="2" y="7" width="20" height="14" rx="2"></rect>
                        <path d="M16 3v4"></path><path d="M8 3v4"></path>
                    </svg>
                    <span class="font-semibold">Professional Details</span>
                </div>
                <dl class="divide-y divide-gray-100">
                    @foreach($staffRequest->professional_details as $key => $value)
                    <div class="flex py-3">
                        <dt class="w-48 font-medium text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                        <dd class="flex-1">{{ $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>
        <div class="space-y-6">
            {{-- Photo --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"></circle>
                        <rect x="2" y="14" width="20" height="6" rx="2"></rect>
                    </svg>
                    <span class="font-semibold">Photo</span>
                </div>
                <div class="flex flex-col items-center justify-center h-64">
                    @if($staffRequest->photo)
                        <img src="{{ asset('storage/' . $staffRequest->photo) }}" alt="{{ $staffRequest->name }}" class="max-h-56 object-cover rounded-md shadow border border-gray-200">
                    @else
                        <span class="text-gray-400">No photo provided.</span>
                    @endif
                </div>
            </div>
            {{-- Actions --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9 12l2 2l4 -4"></path>
                    </svg>
                    <span class="font-semibold">Actions</span>
                </div>
                <div class="flex flex-col gap-3">
                    <form action="{{ route('superadmin.staff-requests.approve', $staffRequest) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this request and create a user account?');">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                            Approve
                        </button>
                    </form>
                    <button type="button" class="w-full flex justify-center items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition" onclick="document.getElementById('rejectModalTailwind').classList.remove('hidden')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                        Reject
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal (Tailwind, with basic JS toggle) --}}
<div id="rejectModalTailwind" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-800">Reject Staff Request</h3>
            <button onclick="document.getElementById('rejectModalTailwind').classList.add('hidden')" class="w-9 h-9 flex items-center justify-center rounded hover:bg-gray-100 transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('superadmin.staff-requests.reject', $staffRequest) }}" method="POST">
            @csrf
            <div class="px-6 py-4">
                <label for="rejection_reason" class="block text-gray-700 font-semibold mb-2">Reason for Rejection <span class="text-red-600">*</span></label>
                <textarea class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 transition" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
            </div>
            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                <button type="button" class="bg-gray-100 text-gray-700 px-5 py-2 rounded font-semibold hover:bg-gray-200 transition" onclick="document.getElementById('rejectModalTailwind').classList.add('hidden')">Cancel</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-bold transition">Submit Rejection</button>
            </div>
        </form>
    </div>
</div>
@endsection
