@extends('layouts.admin')

@section('content')

{{-- Success Toast Notification --}}
@if(session('success'))
<div id="toast" style="background-color: #2d5a27;" class="fixed top-5 right-5 z-[100] text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-in fade-in slide-in-from-right-10 duration-500">
    <div class="bg-white/20 p-1.5 rounded-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
    </div>
    <div>
        <p class="text-[10px] font-black uppercase tracking-widest leading-none">Success</p>
        <p class="text-xs font-bold mt-1 opacity-90">{{ session('success') }}</p>
    </div>
</div>
<script>setTimeout(() => { const t = document.getElementById('toast'); if(t) t.remove(); }, 4000);</script>
@endif

<div class="space-y-8 p-4 font-sans">
    
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-100 pb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight text-left">Event Scheduler</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Real-time operations for <span style="color: #2d5a27;" class="font-bold">Barangay 419</span>.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
            <div class="flex bg-white p-1 rounded-2xl border-2 border-slate-100 shadow-sm">
                <a href="{{ route('admin.schedules.index', ['month' => $prevDate->month, 'year' => $prevDate->year]) }}" 
                   class="p-2 hover:bg-slate-50 rounded-xl transition-all text-slate-400 hover:text-[#2d5a27]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="px-4 flex items-center justify-center min-w-[140px]">
                    <span class="text-xs font-black uppercase tracking-widest text-slate-700">{{ $selectedDate->format('F Y') }}</span>
                </div>
                <a href="{{ route('admin.schedules.index', ['month' => $nextDate->month, 'year' => $nextDate->year]) }}" 
                   class="p-2 hover:bg-slate-50 rounded-xl transition-all text-slate-400 hover:text-[#2d5a27]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <a href="{{ route('admin.schedules.index') }}" 
               class="w-full sm:w-auto bg-slate-800 text-white px-8 py-3.5 text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-black shadow-lg transition-all text-center">
                Today
            </a>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        {{-- Calendar Main --}}
        <div class="lg:col-span-3 bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-7 border-b border-slate-100">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                    <div class="py-5 text-center bg-slate-50/50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $dayName }}</span>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-7">
                @php
                    $daysInMonth = $selectedDate->daysInMonth;
                    $firstDayOfWeek = $selectedDate->copy()->startOfMonth()->dayOfWeek;
                @endphp

                @for($i = 0; $i < $firstDayOfWeek; $i++)
                    <div class="h-40 border-b border-r border-slate-50 bg-slate-50/20"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $currentCellDate = $selectedDate->copy()->day($day);
                        $dateString = $currentCellDate->format('Y-m-d');
                        $dayEvents = isset($schedules[$dateString]) ? $schedules[$dateString]->sortBy('schedule_time') : collect();
                        $isToday = $currentCellDate->isToday();
                    @endphp
                    
                    <div onclick="window.location='{{ route('admin.schedules.create', ['date' => $dateString]) }}'"
                         class="h-40 p-4 border-b border-r border-slate-50 hover:bg-slate-50/50 cursor-pointer transition-all group overflow-hidden relative">
                        
                        <div class="flex justify-between items-center mb-3">
                            {{-- Integrated logic for current date indication color --}}
                            @if($isToday)
                                <span style="background-color: #2d5a27;" 
                                      class="text-sm font-black text-white w-9 h-9 flex items-center justify-center rounded-xl shadow-lg shadow-green-900/20">
                                    {{ $day }}
                                </span>
                            @else
                                <span class="text-sm font-black text-slate-500 group-hover:text-[#2d5a27] transition-colors ml-2">
                                    {{ $day }}
                                </span>
                            @endif
                        </div>

                        <div class="space-y-2 overflow-y-auto max-h-[85px] scrollbar-hide">
                            @foreach($dayEvents as $event)
                                <div onclick="event.stopPropagation(); window.location='{{ route('admin.schedules.edit', $event->id) }}'"
                                     class="bg-white border border-slate-100 p-2 rounded-xl shadow-sm hover:border-[#2d5a27] hover:shadow-md transition-all relative pr-7 event-card">
                                    
                                    <button onclick="event.stopPropagation(); confirmDelete('{{ $event->id }}')" 
                                            class="absolute top-1.5 right-1.5 p-1 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-md transition-colors z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <div class="flex items-center gap-1 mb-0.5">
                                        <div style="color: #2d5a27;" class="text-[8px] font-black uppercase tracking-tighter">
                                            {{ \Carbon\Carbon::parse($event->schedule_time)->format('g:i A') }}
                                        </div>
                                        @if($event->image)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-[10px] font-bold text-slate-700 truncate leading-tight uppercase">
                                        {{ $event->title }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 border-b border-slate-50 pb-4">Upcoming Activities</h3>
                
                <div class="space-y-8">
                    @forelse($upcomingActivities as $upcoming)
                        <div onclick="window.location='{{ route('admin.schedules.edit', $upcoming->id) }}'"
                             class="flex items-start space-x-4 group relative pr-8 cursor-pointer">
                            <div class="bg-slate-50 group-hover:bg-[#2d5a27] transition-all p-3 rounded-2xl text-center min-w-[55px]">
                                <div class="text-sm font-black text-slate-800 group-hover:text-white leading-none">{{ \Carbon\Carbon::parse($upcoming->schedule_date)->format('d') }}</div>
                                <div class="text-[9px] font-black text-slate-400 group-hover:text-white/80 uppercase mt-1">{{ \Carbon\Carbon::parse($upcoming->schedule_date)->format('M') }}</div>
                            </div>
                            <div class="overflow-hidden flex-1">
                                <p class="text-[11px] font-black text-slate-800 truncate uppercase tracking-tight group-hover:text-[#2d5a27] transition-colors">{{ $upcoming->title }}</p>
                                <p class="text-[10px] text-slate-400 font-bold mt-0.5">
                                    {{ \Carbon\Carbon::parse($upcoming->schedule_time)->format('g:i A') }}
                                </p>
                                @if($upcoming->image)
                                    <div class="mt-2 rounded-xl overflow-hidden h-12 w-20 border border-slate-100">
                                        <img src="{{ asset('storage/' . $upcoming->image) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                            
                            <button onclick="event.stopPropagation(); confirmDelete('{{ $upcoming->id }}')" 
                                    class="absolute right-0 top-0 opacity-0 group-hover:opacity-100 p-2 text-slate-300 hover:text-red-500 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="text-slate-200 mb-2 font-black text-4xl">!</div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No Events Found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('admin.schedules.create') }}"
               style="background-color: #2d5a27;"
               class="p-8 rounded-[2.5rem] shadow-lg shadow-green-900/20 text-white relative overflow-hidden group flex items-center gap-4 hover:opacity-90 transition-all">
                <div class="relative z-10 flex-1">
                    <h4 class="text-sm font-black uppercase tracking-widest mb-1">New Schedule</h4>
                    <p class="text-white/70 text-[10px] font-medium leading-relaxed">Click a date on the calendar or use this button.</p>
                </div>
                <div class="p-3 bg-white/20 rounded-2xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Hidden Form for Deletion --}}
<form id="delete-event-form" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function confirmDelete(eventId) {
        if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
            const form = document.getElementById('delete-event-form');
            form.action = `/admin/schedules/${eventId}`;
            form.submit();
        }
    }
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .event-card:hover button { opacity: 1; }
</style>
@endsection