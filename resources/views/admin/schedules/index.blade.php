@extends('layouts.admin')

@section('content')
{{-- 
    We use 'p-6' to create a consistent outer gutter and 'space-y-6' 
    to ensure uniform vertical gaps between the header and the grid.
--}}
<div class="p-6 bg-[#f4f7fe] min-h-screen font-sans space-y-6">
    
    {{-- Header Section - Standardized Placement --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Event Scheduler</h1>
            <p class="text-sm text-gray-500">Real-time barangay operations and activity calendar.</p>
        </div>
        
        <div class="flex flex-col items-end gap-1">
            <div class="text-[12px] text-gray-400">
                Home / <span class="text-[#3b82f6]">Schedules</span>
            </div>
            <a href="{{ route('admin.schedules.index') }}" 
               class="text-[11px] font-bold text-blue-500 hover:text-blue-700 uppercase tracking-tight transition-colors">
                Back to Today
            </a>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Main Calendar Card --}}
        <div class="lg:col-span-3 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            {{-- Calendar Header --}}
            <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-white">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">
                    {{ $selectedDate->format('F Y') }}
                </h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.schedules.index', ['month' => $prevDate->month, 'year' => $prevDate->year]) }}" 
                       class="px-3 py-1 text-xs border border-gray-200 rounded hover:bg-gray-50 text-gray-600 transition-colors">
                       &larr; Previous
                    </a>
                    <a href="{{ route('admin.schedules.index', ['month' => $nextDate->month, 'year' => $nextDate->year]) }}" 
                       class="px-3 py-1 text-xs border border-gray-200 rounded hover:bg-gray-50 text-gray-600 transition-colors">
                       Next &rarr;
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-7">
                @foreach(['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'] as $dayName)
                    <div class="p-3 text-center bg-gray-50 border-b border-r border-gray-100">
                        <span class="text-[10px] font-bold text-gray-400 tracking-widest">{{ $dayName }}</span>
                    </div>
                @endforeach

                @php
                    $daysInMonth = $selectedDate->daysInMonth;
                    $firstDayOfWeek = $selectedDate->dayOfWeek;
                @endphp

                @for($i = 0; $i < $firstDayOfWeek; $i++)
                    <div class="h-32 border-b border-r border-gray-50 bg-gray-50/30"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $currentCellDate = $selectedDate->copy()->day($day);
                        $dateString = $currentCellDate->format('Y-m-d');
                        $dayEvents = isset($schedules[$dateString]) ? $schedules[$dateString]->sortBy('schedule_time') : collect();
                        $isToday = $currentCellDate->isToday();
                    @endphp
                    
                    <div onclick="openModal('{{ $dateString }}')" 
                         class="h-32 p-2 border-b border-r border-gray-100 hover:bg-blue-50/30 cursor-pointer transition-all group overflow-hidden {{ $isToday ? 'bg-blue-50/20' : '' }}">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-xs font-semibold {{ $isToday ? 'bg-blue-600 text-white px-1.5 rounded-full' : ($dayEvents->count() > 0 ? 'text-blue-600' : 'text-gray-400') }}">
                                {{ $day }}
                            </span>
                        </div>
                        <div class="space-y-1 overflow-y-auto max-h-[80px] scrollbar-hide">
                            @foreach($dayEvents as $event)
                                <div class="group/item flex flex-col bg-blue-50 border-l-2 border-blue-500 px-1.5 py-1 rounded-sm relative">
                                    <div class="flex justify-between items-start">
                                        <span class="text-[8px] leading-tight font-black text-blue-400 uppercase">
                                            {{ \Carbon\Carbon::parse($event->schedule_time)->format('g:i A') }}
                                        </span>
                                        <form action="{{ route('admin.schedules.destroy', $event->id) }}" method="POST" onclick="event.stopPropagation();">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-blue-300 hover:text-red-500 text-[9px]" onclick="return confirm('Delete event?')">✕</button>
                                        </form>
                                    </div>
                                    <span class="text-[9px] font-bold text-blue-800 truncate uppercase mt-0.5">{{ $event->title }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-xs font-bold text-gray-700 uppercase mb-4 border-b border-gray-50 pb-2">Upcoming Activities</h3>
                <div class="space-y-4">
                    @forelse($upcomingActivities as $upcoming)
                        <div class="flex items-start space-x-3">
                            <div class="bg-blue-600 text-white p-2 rounded text-[10px] font-bold text-center leading-tight min-w-[42px] shadow-sm">
                                {{ \Carbon\Carbon::parse($upcoming->schedule_date)->format('d') }}<br>
                                <span class="opacity-75 uppercase">{{ \Carbon\Carbon::parse($upcoming->schedule_date)->format('M') }}</span>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[11px] font-bold text-gray-800 truncate uppercase">{{ $upcoming->title }}</p>
                                <p class="text-[10px] text-blue-500 font-medium">
                                    {{ \Carbon\Carbon::parse($upcoming->schedule_time)->format('g:i A') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic text-center py-4">No events scheduled</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.schedules.partials.modal')

<script>
    function openModal(date) {
        document.getElementById('modal_date').value = date;
        document.getElementById('scheduleModal').classList.remove('hidden');
        document.getElementById('scheduleModal').classList.add('flex');
    }
    function closeModal() {
        document.getElementById('scheduleModal').classList.add('hidden');
        document.getElementById('scheduleModal').classList.remove('flex');
    }
</script>
@endsection