@extends('layouts.admin')

@section('content')

<div class="p-6 bg-white rounded shadow">

    @if(session('bulk_report'))
        @php $report = session('bulk_report'); @endphp
        <div class="mb-6 p-4 rounded border {{ $report['failed'] > 0 ? 'bg-yellow-50 border-yellow-200' : 'bg-green-50 border-green-200' }}">
            <h3 class="font-bold text-lg mb-2 {{ $report['failed'] > 0 ? 'text-yellow-800' : 'text-green-800' }}">Bulk Upload Summary</h3>
            <ul class="list-disc list-inside text-sm text-gray-700">
                <li><span class="font-semibold text-green-600">{{ $report['imported'] }}</span> questions added successfully.</li>
                <li><span class="font-semibold text-blue-600">{{ $report['skipped'] }}</span> duplicate questions skipped.</li>
                <li><span class="font-semibold text-red-600">{{ $report['failed'] }}</span> questions failed.</li>
            </ul>
            
            @if(!empty($report['errors']))
                <div class="mt-3">
                    <p class="font-semibold text-red-700 text-sm">Failure Reasons:</p>
                    <ul class="list-disc list-inside text-xs text-red-600 mt-1 max-h-32 overflow-y-auto">
                        @foreach($report['errors'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <button type="button" onclick="this.parentElement.remove()" class="text-sm text-gray-500 hover:text-gray-700 mt-2 underline">Dismiss</button>
        </div>
    @endif

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
                <th class="border p-2">Class/Grade</th>
                <th class="border p-2">Subject</th>
                <th class="border p-2">Question</th>
                <th class="border p-2">Marks</th>
        </tr>
        </thead>

        <tbody>
        @foreach($questions as $q)
            <tr>
                <td class="border p-2">{{ $q->class }}</td>
                <td class="border p-2">{{ $q->subject }}</td>
                <td class="border p-2">{{ Str::limit($q->question_text,60) }}</td>
                <td class="border p-2">{{ $q->marks }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <div class="mt-4">
        {{ $questions->links() }}
    </div>

</div>

@endsection
