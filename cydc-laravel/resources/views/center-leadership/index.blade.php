<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Taarifa za Viongozi wa Kituo') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Taarifa za Viongozi wa Kituo</h1>
                <a href="{{ route('center-leadership.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ongeza Taarifa Mpya
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if($centerLeaderships->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jina la Kituo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Idadi ya Viongozi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hali</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarehe</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hatua</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($centerLeaderships as $centerLeadership)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $centerLeadership->center_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ count($centerLeadership->leadership_list) }} Viongozi
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($centerLeadership->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Imeidhinishwa
                                                </span>
                                            @elseif($centerLeadership->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Imekataliwa
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Inasubiri
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $centerLeadership->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('center-leadership.show', $centerLeadership) }}" class="text-blue-600 hover:text-blue-900">Ona</a>
                                                
                                                @if(auth()->user()->role === 'admin' || $centerLeadership->user_id === auth()->id())
                                                    <a href="{{ route('center-leadership.edit', $centerLeadership) }}" class="text-indigo-600 hover:text-indigo-900">Hariri</a>
                                                    
                                                    <form method="POST" action="{{ route('center-leadership.destroy', $centerLeadership) }}" class="inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Futa</button>
                                                    </form>
                                                @endif
                                                
                                                @if(auth()->user()->role === 'admin' && $centerLeadership->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.center-leadership.approve', $centerLeadership) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Idhinisha</button>
                                                    </form>
                                                    
                                                    <form method="POST" action="{{ route('admin.center-leadership.reject', $centerLeadership) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Kataa</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $centerLeaderships->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-lg">Hakuna taarifa za viongozi wa kituo zilizohifadhiwa.</p>
                        <a href="{{ route('center-leadership.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ongeza Taarifa ya Kwanza
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>