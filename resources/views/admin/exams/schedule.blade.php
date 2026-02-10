@extends('layouts.admin')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

<h2 class="text-lg font-semibold mb-4">
Schedule Exam – {{ $exam->title }}
</h2>

<form method="POST"
      action="{{ route('admin.exams.schedule.store',$exam->id) }}">
@csrf

<div class="mb-4">
    <label class="block mb-1">Start Date & Time</label>
    <input type="datetime-local" name="start_at"
           class="border w-full p-2 rounded"
           required
           value="{{ optional($exam->schedule)->start_at }}">
</div>

<div class="mb-4">
    <label class="block mb-1">End Date & Time</label>
    <input type="datetime-local" name="end_at"
           class="border w-full p-2 rounded"
           required
           value="{{ optional($exam->schedule)->end_at }}">
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Save Schedule
</button>

</form>

</div>

@endsection
