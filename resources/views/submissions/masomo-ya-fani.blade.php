<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Masomo ya Fani Records') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="text-xl font-semibold">Masomo ya Fani Records</h3>

                    <a href="{{ route('submissions.masomo-ya-fani.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        + Add Record
                    </a>
                </div>

                <div class="p-6 overflow-x-auto">

                    @if(isset($faniRecords) && $faniRecords->count())
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-900 text-white">
                                    <th class="px-4 py-3 text-left">Date</th>
                                    <th class="px-4 py-3 text-left">Instructor</th>
                                    <th class="px-4 py-3 text-left">Fani</th>
                                    <th class="px-4 py-3 text-left">Topic</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faniRecords as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-800">
                                            {{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-800">
                                            {{ $item->teacher }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-800">
                                            {{ $item->fani_type }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-800">
                                            {{ $item->topic }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded text-xs
                                                {{ $item->status === 'draft'
                                                    ? 'bg-gray-200 text-gray-700'
                                                    : 'bg-green-100 text-green-700' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3">
                                            <div class="flex flex-wrap gap-2">

                                                <a href="{{ route('submissions.masomo-ya-fani.show', $item) }}"
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    View
                                                </a>

                                                <a href="{{ route('submissions.masomo-ya-fani.edit', $item) }}"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>

                                                <form action="{{ route('submissions.masomo-ya-fani.destroy', $item) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $faniRecords->links() }}
                        </div>

                    @else
                        <div class="text-center py-10 text-gray-500">
                            No records found.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>