@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Resident Records</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Centralized database for <span class="text-brgyGreen font-bold not-italic">Barangay 419</span> resident information.
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <a href="#" class="text-gray-400 hover:text-brgyGreen transition-colors">Home</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-brgyGreen">Residents</span>
        </nav>
    </div>

    {{-- Search & Action Bar --}}
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-stretch lg:items-center bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.residents.index') }}" method="GET" class="relative flex-1 group flex items-center">
            <div class="absolute left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-300 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, ID, or email..."
                   class="pl-12 pr-4 py-4 text-xs font-bold border-none rounded-xl focus:ring-0 w-full transition-all bg-transparent placeholder:text-gray-300 uppercase tracking-widest">
            <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}">
            @if(request('search'))
                <a href="{{ route('admin.residents.index', ['sort' => request('sort', 'latest')]) }}" class="absolute right-4 flex items-center text-gray-300 hover:text-red-400">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                </a>
            @endif
        </form>

        {{-- Sort Buttons --}}
        <div class="flex items-center gap-1 px-2">
            @php $currentSort = request('sort', 'latest'); $search = request('search'); @endphp
            @foreach([['latest', 'Latest'], ['az', 'A–Z'], ['id', 'ID #']] as [$val, $label])
                <a href="{{ route('admin.residents.index', ['sort' => $val, 'search' => $search]) }}"
                   class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all
                          {{ $currentSort === $val ? 'bg-brgyGreen text-white shadow-sm' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-700' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- NEW ENTRY BUTTON: Only visible to Captain --}}
        @if(auth()->user()->isCaptain())
        <div class="flex gap-3 px-2 pb-2 lg:pb-0">
            <a href="{{ route('admin.residents.create') }}"
               class="bg-brgyGreen text-white px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                New Entry
            </a>
        </div>
        @endif
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em] border-b border-gray-100">
                        <th class="px-8 py-4 font-black">Profile Information</th>
                        <th class="px-8 py-4 font-black">Contact Details</th>
                        <th class="px-8 py-4 font-black">Voter Status</th>
                        {{-- THE ACTIONS HEADER IS COMPLETELY REMOVED FOR ROLES 2 & 3 --}}
                        @if(auth()->user()->isAdmin())
                            <th class="px-8 py-4 text-right font-black">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($residents as $resident)
                    <tr class="hover:bg-brgyGreen/[0.02] transition-all group">
                        <td class="px-8 py-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-xs border-2 border-white shadow-sm group-hover:border-brgyGreen/20 transition-all">
                                    {{ substr($resident->first_name, 0, 1) }}{{ substr($resident->last_name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-brgyGold mb-0.5 tracking-widest uppercase">ID-{{ str_pad($resident->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-sm font-black text-gray-800 uppercase tracking-tight group-hover:text-brgyGreen transition-colors">
                                        {{ $resident->last_name }}, {{ $resident->first_name }}
                                    </span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $resident->age }} YRS</span>
                                        <span class="text-gray-200 text-xs">•</span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">{{ $resident->gender }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-3">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center gap-2 text-[11px] font-bold text-gray-600 group-hover:text-gray-900 transition-colors">
                                    <div class="p-1 bg-gray-50 rounded group-hover:bg-white transition-colors">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    {{ $resident->email }}
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-3">
                            @if($resident->is_voter)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 text-[9px] font-black rounded-lg border border-green-100 uppercase tracking-widest">
                                    <span class="w-1 h-1 bg-green-500 rounded-full"></span>
                                    Registered
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-400 text-[9px] font-black rounded-lg border border-gray-100 uppercase tracking-widest">
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    Non-Voter
                                </span>
                            @endif
                        </td>
                        
                        {{-- THE ACTIONS COLUMN DATA IS COMPLETELY REMOVED FOR ROLES 2 & 3 --}}
                        @if(auth()->user()->isAdmin())
                        <td class="px-8 py-3 text-right">
                            <div class="flex justify-end gap-3 items-center">
                                <a href="{{ route('admin.residents.edit', $resident->id) }}" 
                                    title="Edit Resident"
                                    class="p-2 bg-green-50 text-brgyGreen rounded-xl border border-green-100 shadow-sm hover:bg-brgyGreen hover:text-white hover:border-brgyGreen hover:-translate-y-0.5 transition-all group/btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <form id="del-res-{{ $resident->id }}" action="{{ route('admin.residents.destroy', $resident->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                </form>
                                <button onclick="confirmDelete('del-res-{{ $resident->id }}', 'Delete resident: {{ addslashes($resident->first_name . ' ' . $resident->last_name) }}?')"
                                        title="Delete Resident"
                                        class="p-2 bg-red-50 text-red-500 rounded-xl border border-red-100 shadow-sm hover:bg-red-500 hover:text-white hover:border-red-500 hover:-translate-y-0.5 transition-all group/btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 bg-gray-50 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest">No Residents Found</h4>
                                <p class="text-xs text-gray-400 mt-1">Try adjusting your search filters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em]">
                    Showing {{ $residents->firstItem() }} to {{ $residents->lastItem() }} of {{ $residents->total() }} entries
                </p>
                <div>
                    {{ $residents->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection