<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin - Program Day Submissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <dt class="text-sm font-medium text-gray-500">Total Submissions</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $submissions->count() }}
                        </dd>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <dt class="text-sm font-medium text-gray-500">Approved Submissions</dt>
                        <dd class="text-lg font-semibold text-green-700">
                            {{ $submissions->where('status', 'approved')->count() }}
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.submissions.index') }}" class="flex flex-wrap gap-4">
                        <div>
                            <label class="block text-sm font-medium">Section</label>
                            <select name="section" class="border rounded px-3 py-2">
                                <option value="">All Sections</option>
                                <option value="masomo_ya_mtaala">Curriculum Studies</option>
                                <option value="fani">Fani</option>
                                <option value="special_program">Special Program</option>
                                <option value="parents">Parents</option>
                                <option value="vikoba">Vikoba</option>
                                <option value="school_vocational_training">Vocational Training</option>
                                <option value="school_others">Others</option>
                            </select>
                        </div>

                        <div class="flex items-end gap-2">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
                            <a href="{{ route('admin.submissions.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Unified Submissions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">All Form Submissions</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Type</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">User</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y">
                            @forelse($allSubmissions as $submission)
                                <tr>
                                    <td class="px-4 py-2">{{ $submission['type'] }}</td>
                                    <td class="px-4 py-2">{{ $submission['title'] }}</td>
                                    <td class="px-4 py-2">{{ $submission['user'] }}</td>

                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                            Approved
                                        </span>
                                    </td>

                                    <td class="px-4 py-2">
                                        {{ $submission['created_at']->format('M d, Y H:i') }}
                                    </td>

                                    <td class="px-4 py-2 flex gap-2">
                                        <a href="{{ route($submission['route_show'], $submission['id']) }}" class="text-indigo-600">View</a>
                                        <a href="{{ route($submission['route_edit'], $submission['id']) }}" class="text-blue-600">Edit</a>

                                        @if(auth()->user()->role === 'admin')
                                            <form method="POST" action="{{ route($submission['route_delete'], $submission['id']) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">
                                        No submissions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
