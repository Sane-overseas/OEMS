@extends('layouts.admin')

@section('title','Select Questions')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">
                Select Questions
            </h1>
            <p class="text-sm text-gray-500">
                {{ $exam->title }} – Class {{ $exam->class }} | {{ $exam->subject }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.exams.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back to exams
            </a>

            <a href="{{ route('admin.questions.create') }}" target="_blank"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                + Add Question
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.exams.attach',$exam->id) }}">
        @csrf

        <!-- Top summary & filters -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">

            <div class="grid md:grid-cols-6 gap-4 items-end">

                <div>
                    <label class="text-xs text-gray-500">Filter by class</label>
                    <input id="filterGrade" class="w-full rounded-lg border-gray-300 text-sm" placeholder="8">
                </div>

                <div>
                    <label class="text-xs text-gray-500">Filter by subject</label>
                    <input id="filterSubject" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Science">
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500">Search question</label>
                    <input id="searchBox" class="w-full rounded-lg border-gray-300 text-sm"
                        placeholder="Search text...">
                </div>

                <div class="md:col-span-2 flex gap-3 justify-end">

                    <div
                        class="inline-flex items-center rounded-full bg-indigo-100 px-4 py-2 text-sm font-semibold text-indigo-700">
                        Selected :
                        <span id="selectedCount" class="ml-1">0</span>
                    </div>

                    <div
                        class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                        Total marks :
                        <span id="totalMarks" class="ml-1">0</span>
                    </div>

                </div>

            </div>

        </div>

        <!-- Question table -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-5 py-3 w-10"></th>
                            <th class="px-5 py-3 text-left">Class</th>
                            <th class="px-5 py-3 text-left">Subject</th>
                            <th class="px-5 py-3 text-left">Question</th>
                            <th class="px-5 py-3 text-left w-24">Marks</th>
                        </tr>
                    </thead>

                    <tbody id="questionTable" class="divide-y">

                        @foreach($questions as $q)
                        <tr class="question-row hover:bg-gray-50" data-grade="{{ strtolower($q->class) }}"
                            data-subject="{{ strtolower($q->subject) }}">

                            <td class="px-5 py-3">
                                <input type="checkbox" class="question-check rounded border-gray-300 text-indigo-600"
                                    name="questions[]" value="{{ $q->id }}" data-marks="{{ $q->marks }}" {{
                                    in_array($q->id, $attached) ? 'checked' : '' }}>

                            </td>

                            <td class="px-5 py-3">
                                {{ $q->class }}
                            </td>

                            <td class="px-5 py-3">
                                {{ $q->subject }}
                            </td>

                            <td class="px-5 py-3 text-gray-800 question-text">
                                {{ $q->question_text }}
                            </td>

                            <td class="px-5 py-3">
                                <span
                                    class="inline-flex rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">
                                    {{ $q->marks }}
                                </span>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="px-6 py-4 border-t bg-white flex justify-end">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Attach Selected Questions
                </button>
            </div>

        </div>

    </form>

</div>


<script>
    const checks = document.querySelectorAll('.question-check');
const selectedCount = document.getElementById('selectedCount');
const totalMarks = document.getElementById('totalMarks');

const filterGrade   = document.getElementById('filterGrade');
const filterSubject = document.getElementById('filterSubject');
const searchBox     = document.getElementById('searchBox');

const rows = document.querySelectorAll('.question-row');

function updateSummary(){
    let c=0,m=0;
    checks.forEach(ch=>{
        if(ch.checked){
            c++;
            m+=parseInt(ch.dataset.marks);
        }
    });
    selectedCount.innerText=c;
    totalMarks.innerText=m;
}

checks.forEach(ch=>{
    ch.addEventListener('change',updateSummary);
});

function applyFilter(){

    const g = filterGrade.value.toLowerCase().trim();
    const s = filterSubject.value.toLowerCase().trim();
    const q = searchBox.value.toLowerCase().trim();

    rows.forEach(r=>{

        const rg = r.dataset.grade;
        const rs = r.dataset.subject;
        const text = r.querySelector('.question-text').innerText.toLowerCase();

        let show = true;

        if(g && rg !== g) show = false;
        if(s && rs !== s) show = false;
        if(q && !text.includes(q)) show = false;

        r.style.display = show ? '' : 'none';

    });
}

filterGrade.addEventListener('keyup',applyFilter);
filterSubject.addEventListener('keyup',applyFilter);
searchBox.addEventListener('keyup',applyFilter);

updateSummary();

</script>

@endsection
