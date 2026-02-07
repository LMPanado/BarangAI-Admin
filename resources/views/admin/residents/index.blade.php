@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Resident Records</h1>
            <p class="text-sm text-gray-500">Manage and view all registered barangay members.</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <form action="{{ route('admin.residents.index') }}" method="GET" class="flex flex-grow md:flex-grow-0">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search name or ID..." 
                       class="px-3 py-2 text-sm border border-gray-300 rounded-l focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none w-full md:w-64">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 text-sm font-medium rounded-r hover:bg-gray-700">
                    Search
                </button>
            </form>

            <a href="{{ route('admin.residents.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 text-sm font-medium rounded hover:bg-blue-700 shadow-sm whitespace-nowrap transition-colors">
                + Add Resident
            </a>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs uppercase font-bold">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Full Name</th>
                        <th class="px-4 py-3">Contact</th>
                        <th class="px-4 py-3 text-center">Age/Sex</th>
                        <th class="px-4 py-3 text-center">Voter</th>
                        {{-- Changed text-right to text-center for better alignment balance --}}
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @foreach($residents as $resident)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-mono text-gray-400">
                            #{{ str_pad($resident->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-gray-900">{{ $resident->last_name }}, {{ $resident->first_name }}</div>
                            <div class="text-xs text-gray-400">{{ $resident->civil_status ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-xs">{{ $resident->email }}</div>
                            <div class="text-xs text-gray-500">{{ $resident->phone }}</div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ $resident->age }} <span class="text-gray-400">/</span> {{ substr($resident->gender, 0, 1) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($resident->is_voter)
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded-full">YES</span>
                            @else
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full">NO</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            {{-- This Flex container ensures the buttons are on one straight line --}}
                            <div class="flex items-center justify-center gap-4">
                                <a href="{{ route('admin.residents.edit', $resident->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase tracking-tight transition-colors">
                                   Edit
                                </a>
                                
                                <form action="{{ route('admin.residents.destroy', $resident->id) }}" method="POST" 
                                      onsubmit="return confirm('Delete this record?')" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-tight transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-2">
        {{ $residents->links() }}
    </div>
</div>
@endsection