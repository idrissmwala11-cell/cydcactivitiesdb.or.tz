@extends('layouts.app')

@section('title', 'VIONGOZI WA NJE YA WIZARA')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">VIONGOZI WA NJE YA WIZARA</h2>
                    <a href="{{ route('out-of-ministry-leadership.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        <i class="bi bi-plus-circle me-1"></i>Ongeza Rekodi Mpya
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Data Table -->
                @if($outOfMinistryLeaders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Idadi ya Viongozi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Muda wa Kumaliza</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Tarehe ya Kuwasilisha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Imewasilishwa na</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Hatua</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($outOfMinistryLeaders as $leader)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $leader->leaders_count }} Viongozi
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $leader->term_end ? $leader->term_end->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $leader->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $leader->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('out-of-ministry-leadership.show', $leader) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    <i class="bi bi-eye"></i> Ona
                                                </a>
                                                @if(Auth::user()->role === 'admin' || $leader->user_id === Auth::id())
                                                    <a href="{{ route('out-of-ministry-leadership.edit', $leader) }}" 
                                                       class="text-yellow-600 hover:text-yellow-900">
                                                        <i class="bi bi-pencil"></i> Hariri
                                                    </a>
                                                    <form action="{{ route('out-of-ministry-leadership.destroy', $leader) }}" 
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <i class="bi bi-trash"></i> Futa
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
                    <div class="mt-4">
                        {{ $outOfMinistryLeaders->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="bi bi-inbox display-1 text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-gray-500 mt-4 text-xl">Hakuna taarifa za viongozi wa nje ya wizara</h4>
                        <p class="text-gray-400 mt-2">Anza kwa kuongeza rekodi ya kwanza ya viongozi wa nje ya wizara.</p>
                        <a href="{{ route('out-of-ministry-leadership.create') }}" class="btn btn-primary mt-4 inline-block bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600">
            <i class="bi bi-plus-circle me-1"></i>Ongeza Rekodi Mpya
        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection