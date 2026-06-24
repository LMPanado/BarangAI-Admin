@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-end pb-5 border-b border-gray-100">
        <div>
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">{{ now()->format('l, F j, Y') }}</p>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-400 font-medium mt-0.5">Barangay 419 — Overview</p>
        </div>
        <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-300">Home</span>
            <svg class="w-3 h-3 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Dashboard</span>
        </nav>
    </div>

    {{-- Top Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $stats = [
            ['label' => 'Total Residents',    'value' => $totalPopulation, 'color' => 'text-brgyGreen',  'bg' => 'bg-green-50',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label' => 'Male',               'value' => $maleCount,       'color' => 'text-blue-600',   'bg' => 'bg-blue-50',   'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['label' => 'Female',             'value' => $femaleCount,     'color' => 'text-pink-500',   'bg' => 'bg-pink-50',   'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['label' => 'Registered Voters',  'value' => $voterCount,      'color' => 'text-amber-600',  'bg' => 'bg-amber-50',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="shrink-0 w-10 h-10 {{ $stat['bg'] }} rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 {{ $stat['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $stat['label'] }}</p>
                <p class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Quick Actions (role 2 & 3 only — not IT admin) --}}
    @if(auth()->user()->role !== 1)
    <div class="grid grid-cols-3 gap-4">
        <a href="{{ route('admin.documents.index') }}"
           class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center gap-4 hover:border-amber-200 hover:bg-amber-50/40 transition-all group">
            <div class="shrink-0 w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Pending</p>
                <p class="text-xl font-extrabold text-amber-600">{{ $pendingRequests }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Doc Requests</p>
            </div>
        </a>
        <a href="{{ route('admin.schedules.index') }}"
           class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center gap-4 hover:border-blue-200 hover:bg-blue-50/40 transition-all group">
            <div class="shrink-0 w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Upcoming</p>
                <p class="text-xl font-extrabold text-blue-600">{{ \App\Models\Schedule::where('schedule_date', '>=', now()->toDateString())->count() }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Events</p>
            </div>
        </a>
        <a href="{{ route('admin.complaints.index') }}"
           class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center gap-4 hover:border-red-200 hover:bg-red-50/40 transition-all group">
            <div class="shrink-0 w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center group-hover:bg-red-100 transition-colors">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Open</p>
                <p class="text-xl font-extrabold text-red-500">{{ \App\Models\Complaint::where('status', 'open')->count() }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Complaints</p>
            </div>
        </a>
    </div>
    @endif

    {{-- Main content row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Age groups + charts --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Age Groups --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-5">Population by Age Group</h3>
                @php $maxAge = max(array_values($ageGroups)) ?: 1; @endphp
                <div class="space-y-4">
                    @foreach($ageGroups as $label => $count)
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold text-gray-500 w-36 shrink-0">{{ $label }}</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-brgyGreen rounded-full transition-all duration-500"
                                 style="width: {{ $maxAge > 0 ? round($count / $maxAge * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-xs font-extrabold text-brgyGreen w-8 text-right shrink-0">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-4">Gender</h3>
                    <div class="h-[180px]"><canvas id="genderChart"></canvas></div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-4">Voter Status</h3>
                    <div class="h-[180px]"><canvas id="voterChart"></canvas></div>
                </div>
            </div>
        </div>

        {{-- Right: Council --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h3 class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Barangay Council</h3>
            </div>
            <div class="divide-y divide-gray-50 max-h-[480px] overflow-y-auto custom-scrollbar">
                <div class="px-6 py-4 bg-green-50/60 flex items-center gap-3">
                    <div class="w-8 h-8 bg-brgyGreen rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-gray-800 uppercase">Erwin R. Molina</p>
                        <p class="text-[10px] text-brgyGreen font-bold uppercase tracking-widest">Punong Barangay</p>
                    </div>
                </div>
                @php
                $officials = [
                    ['Victoria S. Burlaos',       'Secretary'],
                    ['Romeo R. De Leon',           'Treasurer'],
                    ['John Carlo C. Solomon',      'Kagawad — Appropriations'],
                    ['Reynaldo J. Dauz Jr.',       'Kagawad — Peace & Order'],
                    ['Jesus C. Anunciacion',       'Kagawad — Rules & Education'],
                    ['Claudine A. Dizon',          'Kagawad — Livelihood'],
                    ['Ian M. Perez',               'Kagawad — Health'],
                    ['Ma. Teresita G. Quintana',   'Kagawad — Environment'],
                    ['Enerson R. Molina',          'Kagawad — Entrepreneurship'],
                    ['Alaine Joy T. Ambito',       'Chairperson (SK)'],
                    ['Rustico B. Cuevas Jr.',      'Executive Officer (BSG)'],
                ];
                @endphp
                @foreach($officials as $official)
                <div class="px-6 py-3.5 hover:bg-gray-50 transition-colors group">
                    <p class="text-xs font-bold text-gray-700 group-hover:text-brgyGreen transition-colors">{{ $official[0] }}</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">{{ $official[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Audit Log (role 1 only) --}}
    @if(auth()->user()->role === 1 && $recentLogs->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Recent Activity</h3>
            <a href="{{ route('admin.audit-logs.index') }}"
               class="text-[10px] font-black uppercase tracking-widest text-brgyGreen hover:underline">View All →</a>
        </div>
        @php
        $actionColors = [
            'created'        => ['bg'=>'bg-green-100',  'text'=>'text-green-700'],
            'updated'        => ['bg'=>'bg-blue-100',   'text'=>'text-blue-700'],
            'deleted'        => ['bg'=>'bg-red-100',    'text'=>'text-red-700'],
            'status_changed' => ['bg'=>'bg-amber-100',  'text'=>'text-amber-700'],
            'role_changed'   => ['bg'=>'bg-purple-100', 'text'=>'text-purple-700'],
            'login'          => ['bg'=>'bg-teal-100',   'text'=>'text-teal-700'],
            'logout'         => ['bg'=>'bg-gray-100',   'text'=>'text-gray-600'],
        ];
        @endphp
        <div class="divide-y divide-gray-50">
            @foreach($recentLogs as $log)
            @php $c = $actionColors[$log->action] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-600']; @endphp
            <div class="px-6 py-3.5 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="shrink-0">
                    <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $c['bg'] }} {{ $c['text'] }}">
                        {{ str_replace('_', ' ', $log->action) }}
                    </span>
                </div>
                <p class="flex-1 text-xs text-gray-600 truncate">
                    <span class="{{ $c['text'] }} font-black">{{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'Unknown' }}</span>
                    <span class="font-medium"> {{ str_replace('_', ' ', $log->action) }} </span>
                    <span class="font-bold text-gray-700">{{ $log->subject_label }}</span>
                </p>
                <p class="shrink-0 text-[10px] text-gray-300 font-medium">{{ $log->created_at->diffForHumans() }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{ data: [{{ $maleCount }}, {{ $femaleCount }}], backgroundColor: ['#3b82f6','#ec4899'], borderWidth: 0, hoverOffset: 4 }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 10, weight: 'bold' } } } },
            cutout: '68%'
        }
    });

    new Chart(document.getElementById('voterChart'), {
        type: 'doughnut',
        data: {
            labels: ['Voters', 'Non-Voters'],
            datasets: [{ data: [{{ $voterCount }}, {{ $totalPopulation - $voterCount }}], backgroundColor: ['#f59e0b','#e5e7eb'], borderWidth: 0, hoverOffset: 4 }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 10, weight: 'bold' } } } },
            cutout: '68%'
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
</style>
@endsection
