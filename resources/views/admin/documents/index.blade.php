@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-[1600px] mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-end pb-5 border-b border-gray-100">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Document Requests</h1>
            <p class="text-sm text-gray-400 font-medium mt-0.5">Barangay 419 — Certificates & Permits</p>
        </div>
        <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-300">Home</span>
            <svg class="w-3 h-3 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Requests</span>
        </nav>
    </div>

    {{-- Search + Stats --}}
    <div class="flex items-center gap-4">
        {{-- Search --}}
        <form action="{{ route('admin.documents.index') }}" method="GET" class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-300 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search resident or purpose..."
                   class="pl-10 pr-4 py-2.5 text-xs font-bold border border-gray-200 rounded-xl focus:border-brgyGreen focus:ring-0 outline-none w-64 transition-all bg-white placeholder:text-gray-300 placeholder:font-medium">
        </form>

        {{-- Stats --}}
        <div class="flex items-center gap-3 ml-auto">
            @php
            $statItems = [
                ['label' => 'Pending',       'count' => $requests->where('status','pending')->count(),          'color' => 'text-amber-500',   'bg' => 'bg-amber-50'],
                ['label' => 'Processing',    'count' => $requests->where('status','processing')->count(),       'color' => 'text-violet-500',  'bg' => 'bg-violet-50'],
                ['label' => 'Ready',         'count' => $requests->where('status','ready_for_pickup')->count(), 'color' => 'text-blue-500',    'bg' => 'bg-blue-50'],
                ['label' => 'Completed',     'count' => $requests->where('status','completed')->count(),        'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
            ];
            @endphp
            @foreach($statItems as $s)
            <div class="flex items-center gap-2 bg-white border border-gray-100 rounded-xl px-4 py-2.5">
                <span class="text-lg font-extrabold {{ $s['color'] }}">{{ $s['count'] }}</span>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $s['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- MOBILE APP REQUESTS --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Mobile App Requests</h2>
            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $mobileRequests->count() }} {{ Str::plural('entry', $mobileRequests->count()) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <table class="w-full text-left table-fixed">
                <colgroup>
                    <col class="w-[22%]">
                    <col class="w-[16%]">
                    <col class="w-[24%]">
                    <col class="w-[12%]">
                    <col class="w-[14%]">
                    <col class="w-[12%]">
                </colgroup>
                <thead>
                    <tr class="border-b border-gray-50 text-gray-300 text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-3">Resident</th>
                        <th class="px-6 py-3">Document</th>
                        <th class="px-6 py-3">Purpose</th>
                        <th class="px-6 py-3">Schedule</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($mobileRequests as $req)
                    @include('admin.documents._row', ['request' => $req, 'showVerify' => false])
                    @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-[10px] font-black text-gray-300 uppercase tracking-widest">No mobile requests</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- WALK-IN / KIOSK REQUESTS --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Walk-in / Kiosk Requests</h2>
            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $kioskRequests->count() }} {{ Str::plural('entry', $kioskRequests->count()) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <table class="w-full text-left table-fixed">
                <colgroup>
                    <col class="w-[22%]">
                    <col class="w-[16%]">
                    <col class="w-[24%]">
                    <col class="w-[12%]">
                    <col class="w-[14%]">
                    <col class="w-[12%]">
                </colgroup>
                <thead>
                    <tr class="border-b border-gray-50 text-gray-300 text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-3">Resident</th>
                        <th class="px-6 py-3">Document</th>
                        <th class="px-6 py-3">Purpose</th>
                        <th class="px-6 py-3">Schedule</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kioskRequests as $req)
                    @include('admin.documents._row', ['request' => $req, 'showVerify' => true])
                    @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-[10px] font-black text-gray-300 uppercase tracking-widest">No kiosk requests</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
