@extends('layouts.admin')

@section('content')

<div class="p-6 bg-white rounded shadow">

    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Question Bank</h2>

        <a href="{{ route('admin.questions.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            Add Question
        </a>
    </div>

    <table class="w-full border">

        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Class</th>
                <th class="border p-2">Subject</th>
                <th class="border p-2">Question</th>
                <th class="border p-2">Marks</th>
                <th class="border p-2">Difficulty</th>
            </tr>
        </thead>

        <tbody>
        @foreach($questions as $q)
            <tr>
                <td class="border p-2">{{ $q->class }}</td>
                <td class="border p-2">{{ $q->subject }}</td>
                <td class="border p-2">{{ Str::limit($q->question_text,60) }}</td>
                <td class="border p-2">{{ $q->marks }}</td>
                <td class="border p-2">{{ $q->difficulty }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <div class="mt-4">
        {{ $questions->links() }}
    </div>

</div>

@endsection
