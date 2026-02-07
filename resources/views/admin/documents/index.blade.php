@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header Section - Matched to Resident Records --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Document Issuance</h1>
            <p class="text-sm text-gray-500">Manage and generate official barangay certifications and permits.</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            {{-- Search Bar UI - Matched to Resident Records --}}
            <form action="{{ route('admin.documents.index') }}" method="GET" class="flex flex-grow md:flex-grow-0">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search name or ID..." 
                       class="px-3 py-2 text-sm border border-gray-300 rounded-l focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none w-full md:w-64">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 text-sm font-medium rounded-r hover:bg-gray-700">
                    Search
                </button>
            </form>
        </div>
    </div>

    {{-- Main Table Card - Matched to Resident Records --}}
    <div class="bg-white border border-gray-200 rounded shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs uppercase font-bold">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Full Name</th>
                        <th class="px-4 py-3">Address</th>
                        <th class="px-4 py-3 text-center">Age/Sex</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($residents as $resident)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- ID Column --}}
                        <td class="px-4 py-3 font-mono text-gray-400">
                            #{{ str_pad($resident->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        
                        {{-- Full Name Column --}}
                        <td class="px-4 py-3">
                            <div class="font-bold text-gray-900">{{ $resident->last_name }}, {{ $resident->first_name }}</div>
                            <div class="text-xs text-gray-400 uppercase tracking-tighter">Verified Resident</div>
                        </td>
                        
                        {{-- Address Column --}}
                        <td class="px-4 py-3">
                            <div class="text-xs text-gray-500 italic">{{ $resident->address }}</div>
                        </td>
                        
                        {{-- Age/Sex Column --}}
                        <td class="px-4 py-3 text-center">
                            {{ $resident->age }} <span class="text-gray-400">/</span> {{ strtoupper(substr($resident->gender, 0, 1)) }}
                        </td>
                        
                        {{-- Actions Column --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center">
                                <a href="{{ route('admin.documents.create', $resident->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase tracking-tight transition-colors">
                                    Generate
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-400 italic">
                            No resident records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination Support --}}
    @if(method_exists($residents, 'links'))
    <div class="pt-2">
        {{ $residents->links() }}
    </div>
    @endif
</div>
@endsection