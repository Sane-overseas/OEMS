@extends('layouts.admin')

@section('title','Passages')

@section('content')

<div class="max-w-6xl mx-auto space-y-5">

    <div class="flex justify-between">
        <h2 class="text-xl font-semibold">Passages</h2>

        <a href="{{ route('admin.passages.create') }}"
           class="px-4 py-2 bg-indigo-600 text-white rounded">
            Add Passage
        </a>
    </div>

    <div class="bg-white border rounded-xl overflow-hidden">

        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left">Class</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Passage</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($passages as $p)
                <tr>
                    <td class="p-3">{{ $p->class }}</td>
                    <td class="p-3">{{ $p->subject }}</td>
                    <td class="p-3">{{ $p->title }}</td>
                    <td class="p-3">
                        {{ Str::limit($p->content,80) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-3 border-t">
            {{ $passages->links() }}
        </div>

    </div>

</div>

@endsection
