@extends('layouts.admin')

@section('title', 'Add New Staff - Review')

@section('content')
<div class="flex justify-center w-full bg-gray-50 py-10 min-h-screen">
    <div class="w-full max-w-3xl">
        <div class="bg-white shadow-lg rounded-lg">
            <div class="px-8 py-6 border-b border-gray-100 flex flex-col gap-1">
                <h2 class="text-2xl font-bold text-blue-700">Add New Staff</h2>
                <p class="text-gray-500 text-sm">Step 4: Review & Submit</p>
            </div>
            <div class="px-8 py-8">
                @include('admin.staff.wizard.partials.stepper', ['currentStep' => 4])

                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Review Information</h3>
                    <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50">Name</th>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $wizardData['step1']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50">Email</th>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $wizardData['step1']['email'] }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50">Mobile</th>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $wizardData['step1']['mobile'] }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50">Staff Type</th>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $wizardData['step1']['staff_type'])) }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50">Role</th>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $wizardData['step3']['role'])) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.staff.create.submit') }}" class="mt-6">
                    @csrf

                    <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.staff.create.step3') }}"
                           class="inline-flex items-center px-5 py-2 bg-transparent border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition">
                            <svg class="h-4 w-4 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                            Submit for Verification
                            <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
