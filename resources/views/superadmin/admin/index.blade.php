@extends('layouts.superadmin')

@section('title', 'Admin List')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <h4 class="text-2xl font-bold text-gray-800 mb-0">Admin Management</h4>
    <a href="{{ route('superadmin.admins.create') }}"
        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Add New Admin
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">School</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold mr-4 text-lg">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $admin->name }}</div>
                                <div class="text-xs text-gray-500">{{ $admin->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block rounded-full px-3 py-1 text-xs bg-gray-100 text-gray-700">
                            {{ str_replace('_', ' ', $admin->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($admin->school)
                        <span class="text-gray-800">{{ $admin->school->name }}</span>
                        @else
                        <span class="text-gray-400 italic text-xs">Global / None</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $statusClasses = [
                        'active' => 'bg-green-100 text-green-700',
                        'blocked' => 'bg-red-100 text-red-700',
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        ];
                        $statusClass = $statusClasses[$admin->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="inline-block rounded px-3 py-1 text-xs {{ $statusClass }} capitalize">
                            {{ $admin->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        {{ $admin->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div x-data="{ open: false }" class="relative inline-block" @click.away="open = false">
                            <button 
                                type="button"
                                @click="open = !open"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                </svg>
                            </button>
                            <div 
                                x-cloak
                                x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-2 w-44 bg-white rounded-md shadow-lg border border-gray-200 py-1"
                                style="display: none;"
                            >
                                <a href="{{ route('superadmin.admins.edit', $admin->id) }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15.232 5.232l3.536 3.536M9 13h3L21 7l-3-3L9 13z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            d="M12 9v2m0 4h.01M10 17h4a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" />
                                    </svg>
                                    Permissions
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="#"
                                    class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7M9 7V5a2 2 0 1 1 4 0v2m-6 0h12" />
                                    </svg>
                                    Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-20">
                        <div class="flex flex-col items-center text-gray-400">
                            <svg class="w-14 h-14 mb-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 17.232A3 3 0 1 1 8.768 17.232M9 9v1m6-1v1m-3 3a4 4 0 1 0 8 0 4 4 0 0 0-8 0z" />
                            </svg>
                            <p class="text-gray-500 text-sm">No admins found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($admins->hasPages())
    <div class="bg-gray-50 border-t px-6 py-4">
        {{ $admins->links() }}
    </div>
    @endif
</div>
@endsection