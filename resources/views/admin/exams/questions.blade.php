@extends('layouts.admin')

@section('content')

<div class="p-6 bg-white rounded shadow">

<h2 class="text-lg font-semibold mb-4">
Attach Questions – {{ $exam->title }}
</h2>

<form method="POST" action="{{ route('admin.exams.attach-questions',$exam->id) }}">
@csrf

<table class="w-full border">

<tr class="bg-gray-100">
<th></th>
<th>Question</th>
<th>Marks</th>
</tr>

@foreach($questions as $q)
<tr>
<td class="border p-2">
    <input type="checkbox" name="questions[]" value="{{ $q->id }}">
</td>
<td class="border p-2">
    {{ $q->question_text }}
</td>
<td class="border p-2">
    {{ $q->marks }}
</td>
</tr>
@endforeach

</table>

<button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
Save Questions
</button>

</form>

</div>

@endsection
