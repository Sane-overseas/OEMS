@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">

    <h2 class="text-xl font-semibold mb-4">Add Question</h2>

    <form method="POST" action="{{ route('admin.questions.store') }}">
        @csrf

        <div class="grid grid-cols-2 gap-4 mb-4">

            <div>
                <label>Class</label>
                <input type="text" name="class" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Subject</label>
                <input type="text" name="subject" class="w-full border rounded px-3 py-2" required>
            </div>

        </div>

        <div class="mb-4">
            <label>Question</label>
            <textarea name="question_text" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">

            <div>
                <label>Marks</label>
                <input type="number" name="marks" value="1" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Difficulty</label>
                <select name="difficulty" class="w-full border rounded px-3 py-2">
                    <option value="">--</option>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>

        </div>

        <hr class="my-4">

        <h4 class="font-semibold mb-2">Options</h4>

        @for($i=0;$i<4;$i++)
        <div class="flex items-center gap-2 mb-2">

            <input type="radio" name="correct_option" value="{{ $i }}" required>

            <input type="text" name="options[]" class="flex-1 border rounded px-3 py-2" placeholder="Option {{ $i+1 }}" required>

        </div>
        @endfor

        <button class="mt-4 bg-blue-600 text-white px-5 py-2 rounded">
            Save Question
        </button>

    </form>

</div>

@endsection
