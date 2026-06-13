<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Center Leadership Details') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('center-leadership.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L6.586 10l4.707-4.707a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Back
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 border-2 border-blue-300">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 uppercase">CENTER LEADERSHIP INFORMATION</h2>
                </div>
                
                <!-- Status Badge -->
                <div class="mb-6 text-center">
                    @if($centerLeadership->status === 'approved')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Approved
                        </span>
                    @elseif($centerLeadership->status === 'rejected')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Rejected
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Pending Approval
                        </span>
                    @endif
                </div>

                <!-- TAARIFA ZA MSINGI Section -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">BASIC INFORMATION</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Center Name:</label>
                                @if(preg_match('/^\d+$/', (string) $centerLeadership->center_name))
                                    <p class="mt-1 text-sm text-amber-700">The center name was not saved correctly. Edit this record and enter the correct center name.</p>
                                @else
                                    <p class="mt-1 text-sm text-gray-900">{{ $centerLeadership->center_name }}</p>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Submission Date:</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $centerLeadership->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Submitted By:</label>
                                <p class="mt-1 text-sm text-gray-900"><x-user-identity :user="$centerLeadership->user" :show-email="true" /></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Leaders:</label>
                                <p class="mt-1 text-sm text-gray-900">{{ count($centerLeadership->leadership_list) }} Leaders</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ORODHA YA VIONGOZI Section -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">LEADERS LIST</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">No.</th>
                                    <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Leader Name</th>
                                    <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Leader Number</th>
                                    <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($centerLeadership->leadership_list as $leader)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border border-gray-300 text-sm">{{ $leader['namba'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300 text-sm">{{ $leader['jina_la_kiongozi'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300 text-sm">{{ $leader['namba_ya_kiongozi'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300 text-sm">{{ $leader['cheo'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- CHANGAMOTO Section -->
                @if($centerLeadership->challenges)
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">CHALLENGES</h3>
                        
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $centerLeadership->challenges }}</p>
                        </div>
                    </div>
                @endif

                <!-- MAONI Section -->
                @if($centerLeadership->feedback)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">COMMENTS</h3>
                        
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $centerLeadership->feedback }}</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        @if(auth()->user()->role === 'admin' || $centerLeadership->user_id === auth()->id())
                            <a href="{{ route('center-leadership.edit', $centerLeadership) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                        @endif
                        
                        @if(auth()->user()->role === 'admin' && $centerLeadership->status === 'pending')
                            <form method="POST" action="{{ route('admin.center-leadership.approve', $centerLeadership) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Approve
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.center-leadership.reject', $centerLeadership) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Reject
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    @if(auth()->user()->role === 'admin' || $centerLeadership->user_id === auth()->id())
                        <form method="POST" action="{{ route('center-leadership.destroy', $centerLeadership) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
