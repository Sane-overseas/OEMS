@extends('layouts.admin')

@section('title','Add Passage')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Add Passage</h1>
            <p class="text-sm text-gray-500">
                One passage can be used for multiple questions
            </p>
        </div>

        <a href="{{ route('admin.passages.index') }}"
           class="px-4 py-2 rounded-lg border text-sm">
            Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.passages.store') }}">
        @csrf

        <div class="bg-white border rounded-xl shadow-sm">

            <div class="p-6 space-y-5">

                <div class="grid md:grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm mb-1">Class</label>
                        <input type="text" name="class" required
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Subject</label>
                        <input type="text" name="subject" required
                               class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Title (optional)</label>
                        <input type="text" name="title"
                               class="w-full rounded-lg border-gray-300">
                    </div>

                </div>

                <div>
                    <label class="block text-sm mb-1">
                        Passage / Paragraph
                    </label>

                    <textarea name="content" rows="6" required
                        class="w-full rounded-lg border-gray-300"
                        placeholder="Write the full passage here..."></textarea>
                </div>

            </div>

            <div class="px-6 py-4 border-t flex justify-end">
                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-indigo-600 text-white">
                    Save Passage
                </button>
            </div>

        </div>

    </form>

</div>

@endsection
