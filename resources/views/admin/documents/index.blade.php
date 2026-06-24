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

    {{-- Search --}}
    <div>
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

    {{-- ============================================================ --}}
    {{-- SECTION 1: Mobile App Requests --}}
    {{-- ============================================================ --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-extrabold text-gray-600 uppercase tracking-widest">Mobile App Requests</h2>
            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $mobileRequests->count() }} {{ Str::plural('request', $mobileRequests->count()) }}</span>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                            <th class="px-8 py-5">Resident Info</th>
                            <th class="px-8 py-5">Document</th>
                            <th class="px-8 py-5">Purpose</th>
                            <th class="px-8 py-5">Schedule</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($mobileRequests as $req)
                        @include('admin.documents._row', ['request' => $req, 'showVerify' => false])
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.3em]">No mobile requests found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- SECTION 2: Walk-in / Kiosk Requests --}}
    {{-- ============================================================ --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-extrabold text-gray-600 uppercase tracking-widest">Walk-in / Kiosk Requests</h2>
            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $kioskRequests->count() }} {{ Str::plural('request', $kioskRequests->count()) }}</span>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                            <th class="px-8 py-5">Resident Info</th>
                            <th class="px-8 py-5">Document</th>
                            <th class="px-8 py-5">Purpose</th>
                            <th class="px-8 py-5">Schedule</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($kioskRequests as $req)
                        @include('admin.documents._row', ['request' => $req, 'showVerify' => true])
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center">
                                <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.3em]">No kiosk requests found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
