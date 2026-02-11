@extends('layouts.admin')

@section('title','Edit Exam')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">
                Edit Exam
            </h2>
            <p class="text-sm text-gray-500">
                Update basic exam information
            </p>
        </div>

        <form method="POST" action="{{ route('admin.exams.update',$exam->id) }}">
            @csrf
            @method('PUT')

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Exam title
                    </label>
                    <input type="text" name="title" value="{{ old('title',$exam->title) }}" required
                        class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Exam type
                    </label>
                    <select name="exam_type"
                        class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="practice" @selected($exam->exam_type=='practice')>Practice</option>
                        <option value="mock" @selected($exam->exam_type=='mock')>Mock</option>
                        <option value="final" @selected($exam->exam_type=='final')>Final</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Duration (minutes)
                    </label>
                    <input type="number" min="1" name="duration_minutes"
                        value="{{ old('duration_minutes',$exam->duration_minutes) }}" required
                        class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Passing marks
                    </label>
                    <input type="number" min="0" name="pass_marks" value="{{ old('pass_marks',$exam->pass_marks) }}"
                        class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-2 text-sm text-gray-500">
                    Class: <strong>{{ $exam->class }}</strong> |
                    Subject: <strong>{{ $exam->subject }}</strong>
                </div>

            </div>

            <div class="px-6 py-4 border-t flex justify-end gap-3">

                <a href="{{ route('admin.exams.show',$exam->id) }}"
                    class="px-5 py-2 rounded-lg border text-sm text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button class="px-6 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                    Update Exam
                </button>

            </div>

        </form>

    </div>

</div>

@endsection