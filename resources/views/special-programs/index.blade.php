<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Special Program Records') }}
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
                <div class="p-6 border-b flex items-center justify-between flex-wrap gap-2">
                    <h3 class="text-xl font-semibold">Special Program Records</h3>
                    <x-module-report-actions module="special_program">
                        <a href="{{ route('submissions.special-program.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Add Record
                        </a>
                    </x-module-report-actions>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Teacher</th>
                                <th class="px-4 py-3 text-left">Topic</th>
                                <th class="px-4 py-3 text-left">Age Range</th>
                                <th class="px-4 py-3 text-left">Submitted By</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($specialPrograms as $item)
                                <tr class="border-b">
                                    <td class="px-4 py-3">
                                        {{ $item->date ? \Carbon\Carbon::parse($item->date)->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3">{{ $item->teacher ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->topic ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->age_range ?? '-' }}</td>
                                    <td class="px-4 py-3"><x-user-identity :user="$item->user" :show-email="true" /></td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <a href="{{ route('submissions.special-program.show', $item->id) }}"
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                View
                                            </a>
                                            <a href="{{ route('submissions.special-program.edit', $item->id) }}"
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('submissions.special-program.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center px-4 py-6 text-gray-500">
                                        No records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $specialPrograms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
