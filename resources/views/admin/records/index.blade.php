@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header with Search -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Finalized Records</h1>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form method="GET" action="{{ route('admin.records.index') }}" class="flex gap-2">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" placeholder="Search client/pet..." 
                           value="{{ request('search') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search mr-1"></i> Search
                </button>
            </form>
        </div>
    </div>

    <!-- Date Filter Only -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.records.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Finalized Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Filter
                    </button>
                    @if(request('date'))
                    <a href="{{ route('admin.records.index') }}" 
                       class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Clear
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Records Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet(s)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Finalized</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <!-- ID -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $appointment->id }}
                        </td>
                        
                        <!-- Client -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium">{{ $appointment->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $appointment->user->email }}</div>
                        </td>
                        
                        <!-- Pets -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                @foreach($appointment->pets as $pet)
                                <span class="font-medium">{{ $pet->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        
                        <!-- Finalization Date -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $appointment->updated_at->format('M d, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $appointment->updated_at->diffForHumans() }}
                            </div>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.records.show', $appointment) }}"
                               class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No finalized records found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $appointments->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection