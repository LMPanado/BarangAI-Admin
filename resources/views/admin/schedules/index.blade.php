@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-4 font-sans">
    
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-100 pb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight text-left">Event Scheduler</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Real-time operations for <span class="text-barangayGreen font-bold">Barangay 419</span>.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
            <div class="flex bg-white p-1 rounded-2xl border-2 border-slate-100 shadow-sm">
                <a href="{{ route('admin.schedules.index', ['month' => $prevDate->month, 'year' => $prevDate->year]) }}" 
                   class="p-2 hover:bg-slate-50 rounded-xl transition-all text-slate-400 hover:text-barangayGreen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="px-4 flex items-center justify-center min-w-[140px]">
                    <span class="text-xs font-black uppercase tracking-widest text-slate-700">{{ $selectedDate->format('F Y') }}</span>
                </div>
                <a href="{{ route('admin.schedules.index', ['month' => $nextDate->month, 'year' => $nextDate->year]) }}" 
                   class="p-2 hover:bg-slate-50 rounded-xl transition-all text-slate-400 hover:text-barangayGreen">
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
                    $firstDayOfWeek = $selectedDate->dayOfWeek;
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
                    
                    <div onclick="openModal('{{ $dateString }}')" 
                         class="h-40 p-4 border-b border-r border-slate-50 hover:bg-slate-50/50 cursor-pointer transition-all group overflow-hidden relative">
                        
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-black {{ $isToday ? 'bg-barangayGreen text-white w-8 h-8 flex items-center justify-center rounded-xl shadow-lg shadow-barangayGreen/30' : 'text-slate-400 group-hover:text-barangayGreen' }}">
                                {{ $day }}
                            </span>
                        </div>

                        <div class="space-y-2 overflow-y-auto max-h-[85px] scrollbar-hide">
                            @foreach($dayEvents as $event)
                                <div class="bg-white border border-slate-100 p-2 rounded-xl shadow-sm group-hover:border-barangayGreen/30 transition-all">
                                    <div class="text-[8px] font-black text-barangayGreen uppercase tracking-tighter mb-0.5">
                                        {{ \Carbon\Carbon::parse($event->schedule_time)->format('g:i A') }}
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
                        <div class="flex items-center space-x-4 group">
                            <div class="bg-slate-50 group-hover:bg-barangayGreen transition-all p-3 rounded-2xl text-center min-w-[55px]">
                                <div class="text-sm font-black text-slate-800 group-hover:text-white leading-none">{{ \Carbon\Carbon::parse($upcoming->schedule_date)->format('d') }}</div>
                                <div class="text-[9px] font-black text-slate-400 group-hover:text-white/80 uppercase mt-1">{{ \Carbon\Carbon::parse($upcoming->schedule_date)->format('M') }}</div>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[11px] font-black text-slate-800 truncate uppercase tracking-tight group-hover:text-barangayGreen transition-colors">{{ $upcoming->title }}</p>
                                <p class="text-[10px] text-slate-400 font-bold mt-0.5">
                                    {{ \Carbon\Carbon::parse($upcoming->schedule_time)->format('g:i A') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="text-slate-200 mb-2 font-black text-4xl">!</div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No Events Found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- New Event Prompt --}}
            <div class="bg-barangayGreen p-8 rounded-[2.5rem] shadow-lg shadow-barangayGreen/20 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    <h4 class="text-sm font-black uppercase tracking-widest mb-2">New Schedule?</h4>
                    <p class="text-white/70 text-[10px] font-medium leading-relaxed mb-4">Click any date on the calendar to add a new event or operation.</p>
                </div>
                <div class="absolute -right-4 -bottom-4 text-white/10 group-hover:scale-110 transition-transform duration-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.schedules.partials.modal')

<script>
    function openModal(date) {
        document.getElementById('modal_date').value = date;
        const modal = document.getElementById('scheduleModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex', 'animate-in', 'fade-in', 'duration-300');
    }
    function closeModal() {
        const modal = document.getElementById('scheduleModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection