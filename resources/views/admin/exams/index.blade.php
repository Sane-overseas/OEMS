@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200">

    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
        <h5 class="mb-0 font-semibold text-gray-600 text-lg">
            Exams
        </h5>

        <a href="{{ route('admin.exams.create') }}" class="px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors">
            + Create Exam
        </a>
    </div>

    <div class="p-0">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Class</th>
                        <th class="px-6 py-3">Subject</th>
                        <th class="px-6 py-3">Marks</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    @forelse($exams as $e)

                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $e->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $e->class }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $e->subject }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $e->total_marks }}</td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $badge = match($e->status){
                                        'draft'     => 'bg-gray-100 text-gray-800',
                                        'published' => 'bg-green-100 text-green-800',
                                        'closed'    => 'bg-red-100 text-red-800',
                                        default     => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                    {{ ucfirst($e->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                <a href="{{ route('admin.exams.schedule',$e->id) }}"
                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                    Schedule
                                </a>

                                @if($e->status == 'draft')
                                    <form method="POST"
                                          action="{{ route('admin.exams.publish',$e->id) }}"
                                          class="inline">
                                        @csrf
                                        <button class="text-green-600 hover:text-green-900">
                                            Publish
                                        </button>
                                    </form>

                                @elseif($e->status == 'published')
                                    <form method="POST"
                                          action="{{ route('admin.exams.close',$e->id) }}"
                                          class="inline">
                                        @csrf
                                        <button class="text-red-600 hover:text-red-900">
                                            Close
                                        </button>
                                    </form>

                                @else
                                    <span class="text-gray-400 text-xs ml-2">
                                        Closed
                                    </span>
                                @endif

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No exams found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="px-6 py-4 border-t border-gray-200">
        {{ $exams->links() }}
    </div>

</div>

@endsection
