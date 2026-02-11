@extends('layouts.admin')

@section('title','Add Question')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Add New Question</h1>
        <p class="text-sm text-gray-500">Create a question in the Question Bank</p>
    </div>

    <form method="POST" action="{{ route('admin.questions.store') }}">
        @csrf

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm">

            <!-- Basic info -->
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Question Details
                </h2>
            </div>

            <div class="p-6 space-y-6">

                <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Class / Grade
                        </label>
                        <input type="text" name="class"
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="8" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Subject
                        </label>
                        <input type="text" name="subject"
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Science" required>
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Question
                    </label>
                    <textarea name="question" rows="3"
                        class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Write your question here..." required></textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Marks
                        </label>
                        <input type="number" name="marks" min="1" value="1"
                            class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                </div>

            </div>

            <!-- Options -->
            <div class="border-t px-6 py-4">
                <h3 class="text-md font-semibold text-gray-800 mb-4">
                    Answer Options
                </h3>

                <div class="space-y-3">

                    @for($i = 0; $i < 4; $i++) <div class="flex items-center gap-3">

                        <input type="radio" name="correct" value="{{ $i }}" class="text-indigo-600 border-gray-300"
                            required>

                        <input type="text" name="options[]"
                            class="flex-1 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Option {{ $i+1 }}" required>

                        <span class="text-xs text-gray-400">
                            {{ chr(65+$i) }}
                        </span>

                </div>
                @endfor

            </div>

            <p class="mt-2 text-xs text-gray-500">
                Select the radio button for the correct answer
            </p>

        </div>

        <!-- Actions -->
        <div class="px-6 py-4 border-t flex justify-between items-center">

            <p class="text-xs text-gray-500">
                The question will be added to the Question Bank
            </p>

            <div class="flex gap-3">

                <a href="{{ route('admin.questions.index') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit" name="save_add_more" value="1"
                    class="px-4 py-2 rounded-lg bg-indigo-100 text-indigo-700 text-sm font-medium hover:bg-indigo-200">
                    Save & Add More
                </button>

                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                    Save & Close
                </button>

            </div>

        </div>

</div>

</form>

</div>

@endsection
