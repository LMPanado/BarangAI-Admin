@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-2">
    
    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Document Requests</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Review and process certificates for the residents of <span class="text-brgyGreen font-bold">Barangay 419</span>.</p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Requests</span>
        </nav>
    </div>

        <div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            {{-- Search Bar --}}
            <form action="{{ route('admin.documents.index') }}" method="GET" class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search resident or purpose..." 
                       class="pl-11 pr-4 py-3.5 text-xs font-bold border-2 border-slate-100 rounded-2xl focus:border-brgyGreen focus:ring-0 outline-none w-full transition-all bg-white shadow-sm placeholder:text-slate-400 placeholder:font-black placeholder:uppercase placeholder:tracking-widest">
            </form>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pending</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $requests->where('status', 'pending')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-violet-50 rounded-2xl flex items-center justify-center text-violet-500 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Processing</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $requests->where('status', 'processing')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ready for Pick-up</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $requests->where('status', 'ready_for_pickup')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Completed</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $requests->where('status', 'completed')->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                        <th class="px-8 py-6">Resident Info</th>
                        <th class="px-8 py-6">Document details</th>
                        <th class="px-8 py-6">Purpose</th>
                        <th class="px-8 py-6">Schedule</th>
                        <th class="px-8 py-6">Status Update</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($requests as $request)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="font-bold text-slate-800 text-base leading-tight group-hover:text-brgyGreen transition-colors">
                                @if($request->resident)
                                    {{ $request->resident->first_name }} {{ $request->resident->last_name }}
                                @elseif($request->full_name)
                                    {{ $request->full_name }}
                                @else
                                    <span class="text-gray-400 italic font-medium text-xs">Unknown</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="w-1 h-1 bg-brgyGold rounded-full"></span>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 font-mono">
                                    @if($request->reference_no)
                                        {{ $request->reference_no }}
                                    @else
                                        ID: #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}
                                    @endif
                                </p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-brgyGreen/5 text-brgyGreen text-[10px] font-black rounded-lg border border-brgyGreen/10 uppercase tracking-widest">
                                {{ str_replace('_', ' ', $request->document_type) }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-xs text-slate-500 italic max-w-[180px] line-clamp-2 leading-relaxed">
                                "{{ $request->purpose }}"
                            </p>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-bold text-slate-600">
                                    {{ $request->pickup_date ? \Carbon\Carbon::parse($request->pickup_date)->format('M d, Y') : '—' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <form action="{{ route('admin.documents.updateStatus', $request->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                @php
                                    $selectColor = match($request->status) {
                                        'pending'          => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'processing'       => 'bg-violet-50 text-violet-600 border-violet-100',
                                        'ready_for_pickup' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'completed'        => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'cancelled'        => 'bg-red-50 text-red-600 border-red-100',
                                        default            => 'bg-slate-50 text-slate-500 border-slate-100',
                                    };
                                @endphp
                                <select name="status" onchange="this.form.submit()"
                                    class="text-[9px] font-black uppercase tracking-widest px-4 py-2 rounded-xl border-2 cursor-pointer transition-all focus:ring-0 {{ $selectColor }}">
                                    <option value="pending"          {{ $request->status == 'pending'          ? 'selected' : '' }}>Pending</option>
                                    <option value="processing"       {{ $request->status == 'processing'       ? 'selected' : '' }}>Processing</option>
                                    <option value="ready_for_pickup" {{ $request->status == 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pick-up</option>
                                    <option value="completed"        {{ $request->status == 'completed'        ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled"        {{ $request->status == 'cancelled'        ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-3">
                                {{-- Process Button --}}
                                <a href="{{ route('admin.documents.issuance', $request->id) }}" 
                                   class="p-2.5 bg-brgyGreen/5 text-brgyGreen hover:bg-brgyGreen hover:text-white rounded-xl transition-all duration-300" title="Process Issuance">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </a>
                                
                                {{-- Delete Button --}}
                                <form id="del-doc-{{ $request->id }}" action="{{ route('admin.documents.destroy', $request->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                </form>
                                <button onclick="confirmDelete('del-doc-{{ $request->id }}', 'Delete request #{{ $request->reference_no ?? $request->id }}? This cannot be undone.')"
                                        class="p-2.5 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300" title="Delete Request">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.3em]">No Document Requests Found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if(method_exists($requests, 'hasPages') && $requests->hasPages())
    <div class="pt-6 pb-10">
        <div class="bg-white px-6 py-4 rounded-3xl border border-slate-100 shadow-sm">
            {{ $requests->links() }}
        </div>
    </div>
    @endif
</div>
@endsection