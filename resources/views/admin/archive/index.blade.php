@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Archive</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Deleted records are kept for <span class="text-brgyGreen font-bold not-italic">30 days</span> before being permanently removed.
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">System</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Archive</span>
        </nav>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-xs font-black uppercase tracking-widest">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats Row --}}
    @php
        $totalDeleted = $residents->count() + $announcements->count() + $feedback->count() + $events->count();
        $expiringSoon = collect()
            ->merge($residents)->merge($announcements)->merge($feedback)->merge($events)
            ->filter(fn($r) => $r->deleted_at->diffInDays(now()) >= 25)
            ->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
            <div><p class="text-xl font-extrabold text-gray-800">{{ $totalDeleted }}</p><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Total</p></div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div><p class="text-xl font-extrabold text-gray-800">{{ $residents->count() }}</p><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Residents</p></div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <div><p class="text-xl font-extrabold text-gray-800">{{ $announcements->count() }}</p><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Announcements</p></div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div><p class="text-xl font-extrabold text-gray-800">{{ $events->count() }}</p><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Events</p></div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex items-center gap-3 {{ $expiringSoon > 0 ? 'border-red-100 bg-red-50' : '' }}">
            <div class="w-9 h-9 rounded-xl {{ $expiringSoon > 0 ? 'bg-red-100' : 'bg-gray-100' }} flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 {{ $expiringSoon > 0 ? 'text-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div><p class="text-xl font-extrabold {{ $expiringSoon > 0 ? 'text-red-600' : 'text-gray-800' }}">{{ $expiringSoon }}</p><p class="text-[9px] font-black {{ $expiringSoon > 0 ? 'text-red-400' : 'text-gray-400' }} uppercase tracking-widest">Expiring Soon</p></div>
        </div>
    </div>

    {{-- Search & Filter Bar --}}
    <form method="GET" action="{{ route('admin.archive.index') }}"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-2 flex flex-col sm:flex-row gap-2">
        {{-- Search --}}
        <div class="relative flex-1 group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-300 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Search by name, title, email..."
                   class="pl-11 pr-4 py-3.5 text-xs font-bold border-none rounded-xl focus:ring-0 w-full bg-transparent placeholder:text-gray-300 uppercase tracking-widest">
        </div>

        {{-- Filter Tabs --}}
        <div class="flex items-center gap-1 px-1">
            @foreach(['all' => 'All', 'residents' => 'Residents', 'announcements' => 'Announcements', 'events' => 'Events', 'feedback' => 'Feedback'] as $val => $label)
                <button type="submit" name="filter" value="{{ $val }}"
                        class="px-3 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all
                        {{ $filter === $val ? 'bg-brgyGreen text-white shadow' : 'text-gray-400 hover:text-brgyGreen hover:bg-brgyGreen/5' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Clear --}}
        @if($search || $filter !== 'all')
            <a href="{{ route('admin.archive.index') }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                Clear
            </a>
        @endif
    </form>

    {{-- Info Banner --}}
    <div class="flex items-start gap-4 px-6 py-4 bg-amber-50 border border-amber-100 rounded-2xl">
        <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-xs font-bold text-amber-700 leading-relaxed">
            Archived records are automatically and permanently deleted after <strong>30 days</strong>. Records expiring within 5 days are marked in red. Restore them before they are gone.
        </p>
    </div>

    @php
        $totalDeleted = $residents->count() + $announcements->count() + $feedback->count() + $events->count();
    @endphp

    @if($totalDeleted === 0)
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-20 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5">
                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">
                {{ $search ? 'No results found for "'.$search.'"' : 'Archive is Empty' }}
            </h4>
            <p class="text-xs text-gray-300 font-medium">{{ $search ? 'Try a different search term.' : 'No records have been deleted yet.' }}</p>
        </div>
    @else

    @php
        // helper: days remaining badge
        $daysLeft = function($deletedAt) {
            $expiry = $deletedAt->copy()->addDays(30);
            $days = (int) now()->diffInDays($expiry, false);
            if ($days <= 0)  return ['label' => 'Expiring today', 'class' => 'bg-red-100 text-red-600'];
            if ($days <= 5)  return ['label' => $days.'d left', 'class' => 'bg-red-50 text-red-500'];
            if ($days <= 10) return ['label' => $days.'d left', 'class' => 'bg-orange-50 text-orange-500'];
            return ['label' => $days.'d left', 'class' => 'bg-gray-50 text-gray-400'];
        };
    @endphp

    {{-- ── RESIDENTS ── --}}
    @if($residents->isNotEmpty())
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-8 py-5 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest">Deleted Residents</h2>
                    <p class="text-[10px] text-gray-400 font-bold">{{ $residents->count() }} record(s)</p>
                </div>
            </div>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($residents as $item)
            @php $badge = $daysLeft($item->deleted_at); @endphp
            <div class="flex items-center gap-4 px-8 py-4 hover:bg-gray-50/50 transition-colors {{ $item->deleted_at->diffInDays(now()) >= 25 ? 'bg-red-50/30' : '' }}">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-500 font-extrabold text-xs">{{ strtoupper(substr($item->first_name,0,1).substr($item->last_name,0,1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 text-sm">{{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-0.5 uppercase tracking-widest">{{ $item->gender }} · {{ $item->age }} yrs · {{ $item->address }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:block">Deleted {{ $item->deleted_at->format('M d, Y') }}</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    <form action="{{ route('admin.archive.restore', ['type'=>'resident','id'=>$item->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Restore
                        </button>
                    </form>
                    <form id="perm-resident-{{ $item->id }}" action="{{ route('admin.archive.force-delete', ['type'=>'resident','id'=>$item->id]) }}" method="POST">
                        @csrf @method('DELETE')
                    </form>
                    <button onclick="confirmDelete('perm-resident-{{ $item->id }}', 'Permanently delete {{ addslashes($item->first_name.' '.$item->last_name) }}? This cannot be undone.')"
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-50 text-red-500 border border-red-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Forever
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── ANNOUNCEMENTS ── --}}
    @if($announcements->isNotEmpty())
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-8 py-5 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest">Deleted Announcements</h2>
                    <p class="text-[10px] text-gray-400 font-bold">{{ $announcements->count() }} record(s)</p>
                </div>
            </div>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($announcements as $item)
            @php $badge = $daysLeft($item->deleted_at); @endphp
            <div class="flex items-center gap-4 px-8 py-4 hover:bg-gray-50/50 transition-colors {{ $item->deleted_at->diffInDays(now()) >= 25 ? 'bg-red-50/30' : '' }}">
                @if($item->image_url)
                    <img src="{{ Storage::url($item->image_url) }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 border border-gray-100">
                @else
                    <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 text-sm line-clamp-1">{{ $item->title }}</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-0.5 uppercase tracking-widest">{{ $item->category }} · Posted {{ $item->created_at->format('M d, Y') }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:block">Deleted {{ $item->deleted_at->format('M d, Y') }}</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    <form action="{{ route('admin.archive.restore', ['type'=>'announcement','id'=>$item->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Restore
                        </button>
                    </form>
                    <form id="perm-ann-{{ $item->id }}" action="{{ route('admin.archive.force-delete', ['type'=>'announcement','id'=>$item->id]) }}" method="POST">
                        @csrf @method('DELETE')
                    </form>
                    <button onclick="confirmDelete('perm-ann-{{ $item->id }}', 'Permanently delete this announcement? This cannot be undone.')"
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-50 text-red-500 border border-red-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Forever
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── EVENTS ── --}}
    @if($events->isNotEmpty())
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-8 py-5 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest">Deleted Events</h2>
                    <p class="text-[10px] text-gray-400 font-bold">{{ $events->count() }} record(s)</p>
                </div>
            </div>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($events as $item)
            @php $badge = $daysLeft($item->deleted_at); @endphp
            <div class="flex items-center gap-4 px-8 py-4 hover:bg-gray-50/50 transition-colors {{ $item->deleted_at->diffInDays(now()) >= 25 ? 'bg-red-50/30' : '' }}">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex flex-col items-center justify-center flex-shrink-0 border border-amber-100">
                    <span class="text-amber-600 font-extrabold text-sm leading-none">{{ \Carbon\Carbon::parse($item->schedule_date)->format('d') }}</span>
                    <span class="text-amber-400 text-[9px] font-black uppercase">{{ \Carbon\Carbon::parse($item->schedule_date)->format('M') }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 text-sm line-clamp-1">{{ $item->title }}</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-0.5 uppercase tracking-widest">{{ \Carbon\Carbon::parse($item->schedule_date)->format('M d, Y') }} · {{ \Carbon\Carbon::parse($item->schedule_time)->format('h:i A') }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:block">Deleted {{ $item->deleted_at->format('M d, Y') }}</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    <form action="{{ route('admin.archive.restore', ['type'=>'event','id'=>$item->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Restore
                        </button>
                    </form>
                    <form id="perm-event-{{ $item->id }}" action="{{ route('admin.archive.force-delete', ['type'=>'event','id'=>$item->id]) }}" method="POST">
                        @csrf @method('DELETE')
                    </form>
                    <button onclick="confirmDelete('perm-event-{{ $item->id }}', 'Permanently delete this event? This cannot be undone.')"
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-50 text-red-500 border border-red-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Forever
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── FEEDBACK ── --}}
    @if($feedback->isNotEmpty())
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-8 py-5 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest">Deleted Feedback</h2>
                    <p class="text-[10px] text-gray-400 font-bold">{{ $feedback->count() }} record(s)</p>
                </div>
            </div>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($feedback as $item)
            @php
                $badge = $daysLeft($item->deleted_at);
                $sentimentClass = match($item->sentiment ?? '') {
                    'positive' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                    'negative' => 'text-red-500 bg-red-50 border-red-100',
                    default    => 'text-gray-500 bg-gray-50 border-gray-100',
                };
            @endphp
            <div class="flex items-center gap-4 px-8 py-4 hover:bg-gray-50/50 transition-colors {{ $item->deleted_at->diffInDays(now()) >= 25 ? 'bg-red-50/30' : '' }}">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 text-sm line-clamp-1">{{ $item->message }}</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-0.5 uppercase tracking-widest">{{ $item->user_email }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 border rounded-lg text-[9px] font-black uppercase tracking-widest {{ $sentimentClass }} flex-shrink-0">
                    {{ $item->sentiment ?? 'Neutral' }}
                </span>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:block">Deleted {{ $item->deleted_at->format('M d, Y') }}</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    <form action="{{ route('admin.archive.restore', ['type'=>'feedback','id'=>$item->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Restore
                        </button>
                    </form>
                    <form id="perm-fb-{{ $item->id }}" action="{{ route('admin.archive.force-delete', ['type'=>'feedback','id'=>$item->id]) }}" method="POST">
                        @csrf @method('DELETE')
                    </form>
                    <button onclick="confirmDelete('perm-fb-{{ $item->id }}', 'Permanently delete this feedback? This cannot be undone.')"
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-50 text-red-500 border border-red-100 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Forever
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @endif
</div>
@endsection
