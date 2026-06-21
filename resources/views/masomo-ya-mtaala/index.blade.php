<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum Studies Records') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Curriculum Studies Records</h3>
                    <a href="{{ route('submissions.masomo-ya-mtaala.create') }}"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Add Record
                    </a>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Instructor</th>
                                <th class="px-4 py-3 text-left">Subject</th>
                                <th class="px-4 py-3 text-left">Lesson Topic</th>
                                <th class="px-4 py-3 text-left">Category</th>
                                <th class="px-4 py-3 text-left">Age Group</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Submitted By</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($masomoYaMtaala as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800">
                                        {{ $item->date ? $item->date->format('M d, Y') : 'N/A' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        {{ $item->teacher ?? 'N/A' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        {{ $item->subject_type ?? 'N/A' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        {{ $item->topic ? \Illuminate\Support\Str::limit($item->topic, 40) : 'N/A' }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        {{ $item->category_label }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        {{ $item->age_group ?? 'N/A' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs
                                            @if($item->status === 'draft')
                                                bg-yellow-100 text-yellow-800
                                            @elseif($item->status === 'submitted' || $item->status === 'approved')
                                                bg-green-100 text-green-700
                                            @else
                                                bg-gray-200 text-gray-700
                                            @endif">
                                            {{ ucfirst($item->status ?? 'N/A') }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        <x-user-identity :user="$item->user" :show-email="true" />
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('admin.masomo-ya-mtaala.show', $item) }}"
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    View
                                                </a>

                                                <a href="{{ route('admin.masomo-ya-mtaala.edit', $item) }}"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.masomo-ya-mtaala.destroy', $item) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('submissions.masomo-ya-mtaala.show', $item) }}"
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    View
                                                </a>

                                                <a href="{{ route('submissions.masomo-ya-mtaala.edit', $item) }}"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>

                                                <form action="{{ route('submissions.masomo-ya-mtaala.destroy', $item) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center px-4 py-6 text-gray-500">
                                        No records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $masomoYaMtaala->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
