@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-4">
    
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-100 pb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight text-left">Resident Records</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Manage and view all registered members of <span class="text-barangayGreen font-bold">Barangay 419</span>.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
            {{-- Search Bar --}}
            <form action="{{ route('admin.residents.index') }}" method="GET" class="flex w-full sm:w-auto group">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search name or ID..." 
                       class="px-5 py-3 text-sm border-2 border-slate-100 rounded-l-2xl focus:border-barangayGreen focus:ring-0 outline-none w-full md:w-72 transition-all bg-white shadow-sm">
                <button type="submit" class="bg-slate-800 text-white px-6 py-3 text-xs font-black uppercase tracking-widest rounded-r-2xl hover:bg-black transition-all shadow-sm">
                    Search
                </button>
            </form>

            {{-- FIXED ADD RESIDENT BUTTON --}}
            <a href="{{ route('admin.residents.create') }}" 
               class="w-full sm:w-auto bg-barangayGreen text-white px-8 py-3.5 text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-barangayDark shadow-lg shadow-barangayGreen/20 transition-all duration-300 text-center flex items-center justify-center gap-2">
                <span class="text-lg leading-none">+</span>
                <span>Add Resident</span>
            </a>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                        <th class="px-8 py-5">Resident ID</th>
                        <th class="px-8 py-5">Full Name</th>
                        <th class="px-8 py-5">Contact Details</th>
                        <th class="px-8 py-5 text-center">Age/Sex</th>
                        <th class="px-8 py-5 text-center">Voter Status</th>
                        <th class="px-8 py-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-50">
                    @foreach($residents as $resident)
                    <tr class="hover:bg-slate-50/30 transition-all group">
                        <td class="px-8 py-6 font-mono text-xs font-bold text-slate-400">
                            #{{ str_pad($resident->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-8 py-6">
                            <div class="font-extrabold text-slate-800 text-base tracking-tight group-hover:text-barangayGreen transition-colors">
                                {{ $resident->last_name }}, {{ $resident->first_name }}
                            </div>
                            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-1">
                                {{ $resident->civil_status ?? 'NOT SPECIFIED' }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-xs font-bold text-slate-600">{{ $resident->email }}</div>
                            <div class="text-xs text-slate-400 font-medium mt-0.5">{{ $resident->phone }}</div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="inline-block px-3 py-1 bg-slate-100 rounded-lg font-bold text-slate-700">
                                {{ $resident->age }} <span class="text-slate-400 mx-1">/</span> {{ strtoupper(substr($resident->gender, 0, 1)) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($resident->is_voter)
                                <span class="px-3 py-1 bg-green-50 text-barangayGreen text-[10px] font-black rounded-full border border-green-100">VOTER</span>
                            @else
                                <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[10px] font-black rounded-full border border-slate-100">NON-VOTER</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-6">
                                <a href="{{ route('admin.residents.edit', $resident->id) }}" 
                                   class="text-barangayGreen hover:text-barangayDark font-black text-[10px] uppercase tracking-widest transition-all">
                                    Edit
                                </a>
                                
                                <form action="{{ route('admin.residents.destroy', $resident->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to permanently delete this record?')" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-600 font-black text-[10px] uppercase tracking-widest transition-all">
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

    <div class="pt-4">
        {{ $residents->links() }}
    </div>
</div>
@endsection