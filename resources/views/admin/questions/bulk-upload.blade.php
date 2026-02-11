@extends('layouts.admin')

@section('title','Bulk Upload Questions')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Bulk Upload Questions</h1>
        <p class="text-sm text-gray-500">
            Upload multiple MCQ questions using a CSV file
        </p>
    </div>

    <div class="bg-white border rounded-xl shadow-sm">

        <div class="p-6">

            <form method="POST" action="{{ route('admin.questions.bulk.upload') }}" enctype="multipart/form-data"
                class="space-y-6">

                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Upload CSV file
                    </label>

                    <input type="file" name="file" accept=".csv" required
                        class="block w-full text-sm border border-gray-300 rounded-lg">

                    <p class="mt-2 text-xs text-gray-500">
                        Only CSV file supported
                    </p>
                </div>

                <div class="bg-gray-50 border rounded-lg p-4 text-sm text-gray-700">

                    <p class="font-semibold mb-2">CSV format</p>

                    <pre class="text-xs whitespace-pre-wrap">
class,subject,question,marks,option_a,option_b,option_c,option_d,correct_option

8,Science,What is photosynthesis?,2,Process in plants,Animal breathing,Water cycle,Soil erosion,A
</pre>

                    <p class="mt-2 text-xs text-gray-500">
                        correct_option must be: A, B, C or D
                    </p>

                </div>

                <div class="flex justify-end gap-3">

                    <a href="{{ route('admin.questions.index') }}"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                        Upload Questions
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection