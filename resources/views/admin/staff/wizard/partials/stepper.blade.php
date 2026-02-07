@props(['currentStep'])

@php
$steps = [
    1 => ['title' => 'Basic Info', 'icon' => 'user'],
    2 => ['title' => 'Professional', 'icon' => 'briefcase'],
    3 => ['title' => 'Role & Access', 'icon' => 'key'],
    4 => ['title' => 'Review & Submit', 'icon' => 'check'],
];
@endphp

<div class="mb-6 pt-3">
    <ol class="flex flex-col sm:flex-row items-center justify-between gap-4 md:gap-0 relative">
        @foreach($steps as $step => $details)
            <li class="flex items-center relative flex-1">
                <!-- Connector line (left, except first step) -->
                @if($step > 1)
                    <span class="hidden sm:block absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 
                        {{ $currentStep >= $step ? 'bg-blue-500' : 'bg-gray-300' }}"
                        style="z-index:0;"></span>
                @endif

                <!-- Step Marker -->
                <span class="
                        flex items-center justify-center z-10
                        w-10 h-10 rounded-full
                        text-lg font-semibold
                        border-2
                        transition
                        {{ $currentStep > $step 
                            ? 'bg-blue-600 border-blue-600 text-white'
                            : ($currentStep == $step 
                                ? 'bg-blue-100 border-blue-500 text-blue-700'
                                : 'bg-white border-gray-300 text-gray-400')
                        }}
                    ">
                    @if($currentStep > $step)
                        <!-- Completed: Checkmark SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        @switch($details['icon'])
                            @case('user')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                @break
                            @case('briefcase')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m2 0a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v5a2 2 0 002 2m2-7V5a2 2 0 114 0v2"/>
                                </svg>
                                @break
                            @case('key')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a4 4 0 105.656 5.657l-8.485 8.486a2 2 0 01-2.829 0l-2.121-2.121a2 2 0 010-2.829l8.486-8.485A4 4 0 0015 7z"/>
                                </svg>
                                @break
                            @case('check')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                @break
                            @default
                                {{ $step }}
                        @endswitch
                    @endif
                </span>
                <!-- Step label -->
                <div class="absolute left-1/2 top-12 -translate-x-1/2 text-center w-max
                    text-xs font-semibold
                    {{ $currentStep == $step ? 'text-blue-700' : ($currentStep > $step ? 'text-blue-500' : 'text-gray-400') }}">
                    {{ $details['title'] }}
                </div>
            </li>
        @endforeach
    </ol>
</div>
