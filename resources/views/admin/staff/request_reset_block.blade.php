@extends('layouts.admin')

@section('title', 'Request Reset / Block')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-8 px-2">
    <div class="w-full max-w-2xl">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h5 class="text-xl font-bold text-blue-600 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-3.185 2.185-6 6-6s6 2.815 6 6-2.185 6-6 6-6-2.815-6-6zM15 19l1-7"/></svg>
                    Request Staff Action
                </h5>
            </div>
            <div class="px-8 py-6">

                @if(session('success'))
                    <div class="mb-4 flex items-center bg-green-100 border border-green-300 text-green-800 text-sm px-4 py-3 rounded justify-between" role="alert">
                        <span>
                            {{ session('success') }}
                        </span>
                        <button type="button" onclick="this.parentElement.remove();" class="text-xl leading-none font-semibold text-green-600 transition hover:text-green-800 ml-4" aria-label="Close">&times;</button>
                    </div>
                @endif

                <form action="{{ route('admin.requests.staff.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="user_id" class="block mb-2 font-semibold text-gray-700">Select Staff Member</label>
                        <select class="block w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition" id="user_id" name="user_id" required>
                            <option value="" selected disabled>Choose a staff member...</option>
                            @forelse($staffMembers as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->email }})</option>
                            @empty
                                <option value="" disabled>No staff members found</option>
                            @endforelse
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Select the staff member you wish to perform an action on.</p>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold text-gray-700">Action Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="request_type" id="type_block" value="block_user" class="peer sr-only" checked>
                                <div class="px-4 py-2 rounded-lg border-2 border-gray-200 group-hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 flex items-center gap-2 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364a9 9 0 11-12.728-12.728 9 9 0 0112.728 12.728z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.243 7.757l-8.486 8.486" /></svg>
                                    Block User
                                </div>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="request_type" id="type_unblock" value="unblock_user" class="peer sr-only">
                                <div class="px-4 py-2 rounded-lg border-2 border-gray-200 group-hover:border-green-500 peer-checked:border-green-600 peer-checked:bg-green-50 flex items-center gap-2 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Unblock User
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="reason" class="block mb-2 font-semibold text-gray-700">Reason for Request</label>
                        <textarea class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 transition resize-none bg-gray-50" id="reason" name="reason" rows="4" placeholder="Please provide a reason for this request so the Superadmin can verify..." required></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="reset" class="bg-gray-100 border border-gray-300 text-gray-700 py-2 px-5 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg font-semibold hover:bg-blue-700 flex gap-2 items-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1-8a9 9 0 100 18 9 9 0 000-18z" />
                            </svg>
                            Send Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
