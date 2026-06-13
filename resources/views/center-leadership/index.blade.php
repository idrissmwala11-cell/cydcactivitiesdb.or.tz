<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Center Leadership Information') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">
                    Center Leadership Information
                </h1>

                <a href="{{ route('center-leadership.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Record
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Content Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if($centerLeaderships->count() > 0)

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <!-- Table Head -->
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Center Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Number of Leaders
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Submitted By
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($centerLeaderships as $centerLeadership)
                                    <tr>
                                        <!-- Center Name -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            @if(preg_match('/^\d+$/', (string) $centerLeadership->center_name))
                                                <span class="text-amber-700">Center name not provided</span>
                                            @else
                                                {{ $centerLeadership->center_name }}
                                            @endif
                                        </td>

                                        <!-- Leadership Count -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ count($centerLeadership->leadership_list) }} Leaders
                                        </td>

                                        <!-- Status (Always Approved) -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                                text-xs font-medium bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        </td>

                                        <!-- Date -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $centerLeadership->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <x-user-identity :user="$centerLeadership->user" />
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <!-- View -->
                                                <a href="{{ route('center-leadership.show', $centerLeadership) }}"
                                                   class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>

                                                <!-- Edit & Delete (only admin or owner) -->
                                                @if(auth()->user()->role === 'admin' || $centerLeadership->user_id === auth()->id())
                                                    <a href="{{ route('center-leadership.edit', $centerLeadership) }}"
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </a>

                                                    <form method="POST"
                                                          action="{{ route('center-leadership.destroy', $centerLeadership) }}"
                                                          class="inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-900">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $centerLeaderships->links() }}
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-lg">
                            No center leadership records have been saved yet.
                        </p>

                        <a href="{{ route('center-leadership.create') }}"
                           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700
                                  text-white font-bold py-2 px-4 rounded">
                            Add the First Record
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
