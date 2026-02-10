@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 md:p-10">

            <div class="mb-8 text-center">
                <h5 class="text-xl font-semibold text-gray-900 mb-1">Create Exam</h5>
                <h6 class="text-gray-500 text-sm">Basic exam information</h6>
            </div>

            <form method="POST" action="{{ route('admin.exams.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Exam title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Exam Title</label>
                        <input type="text" name="title" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2.5" placeholder="Enter exam title"
                            required>
                    </div>

                    <!-- Class -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                        <input type="text" name="class" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2.5" placeholder="Class" required>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2.5" placeholder="Subject" required>
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                        <input type="number" name="duration_minutes" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2.5"
                            placeholder="Duration in minutes" min="1" required>
                    </div>

                    <!-- Instructions -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                        <textarea name="instructions" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2.5"
                            placeholder="Exam instructions (optional)"></textarea>
                    </div>

                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Create &amp; Select Questions
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>



@endsection