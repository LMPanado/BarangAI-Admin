@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">

    {{-- ══════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-6">
        <div>
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.25em] mb-1">{{ now()->format('l, F j, Y') }}</p>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Welcome back, <span class="text-brgyGreen font-bold">{{ auth()->user()->first_name }}</span>. Here's what's happening in Barangay 419.</p>
        </div>
        @if(in_array(auth()->user()->role, [2, 3]))
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('admin.residents.create') }}"
               class="px-4 py-2.5 rounded-xl bg-brgyGreen text-white text-[10px] font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-sm">
                + Add Resident
            </a>
            <a href="{{ route('admin.schedules.create') }}"
               class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                + New Event
            </a>
        </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════
         STAT CARDS  (6 cards)
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @php
            $statCards = [
                [
                    'label'   => 'Total Residents',
                    'value'   => $totalPopulation,
                    'icon'    => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                    'bg'      => 'bg-blue-50',
                    'icon_bg' => 'bg-blue-100',
                    'color'   => 'text-blue-600',
                    'border'  => 'border-blue-100',
                    'bar'     => 'bg-blue-500',
                ],
                [
                    'label'   => 'Male',
                    'value'   => $maleCount,
                    'icon'    => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                    'bg'      => 'bg-sky-50',
                    'icon_bg' => 'bg-sky-100',
                    'color'   => 'text-sky-600',
                    'border'  => 'border-sky-100',
                    'bar'     => 'bg-sky-500',
                ],
                [
                    'label'   => 'Female',
                    'value'   => $femaleCount,
                    'icon'    => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                    'bg'      => 'bg-pink-50',
                    'icon_bg' => 'bg-pink-100',
                    'color'   => 'text-pink-500',
                    'border'  => 'border-pink-100',
                    'bar'     => 'bg-pink-500',
                ],
                [
                    'label'   => 'Voters',
                    'value'   => $voterCount,
                    'icon'    => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'bg'      => 'bg-amber-50',
                    'icon_bg' => 'bg-amber-100',
                    'color'   => 'text-amber-600',
                    'border'  => 'border-amber-100',
                    'bar'     => 'bg-amber-500',
                ],
                [
                    'label'   => 'Pending Docs',
                    'value'   => $pendingRequests,
                    'icon'    => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'bg'      => 'bg-orange-50',
                    'icon_bg' => 'bg-orange-100',
                    'color'   => 'text-orange-600',
                    'border'  => 'border-orange-100',
                    'bar'     => 'bg-orange-500',
                ],
                [
                    'label'   => 'Open Complaints',
                    'value'   => \App\Models\Complaint::where('status', 'open')->count(),
                    'icon'    => 'M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z',
                    'bg'      => 'bg-red-50',
                    'icon_bg' => 'bg-red-100',
                    'color'   => 'text-red-500',
                    'border'  => 'border-red-100',
                    'bar'     => 'bg-red-500',
                ],
            ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-white rounded-2xl border {{ $card['border'] }} p-5 flex flex-col gap-3 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <p class="text-[9px] font-black uppercase tracking-[0.18em] text-slate-400">{{ $card['label'] }}</p>
                <div class="{{ $card['icon_bg'] }} p-2 rounded-xl {{ $card['color'] }} group-hover:scale-110 transition-transform">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold {{ $card['color'] }} tracking-tight leading-none">{{ $card['value'] }}</p>
            <div class="h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="{{ $card['bar'] }} h-full rounded-full"
                     style="width: {{ $totalPopulation > 0 ? min(100, round(($card['value'] / max($totalPopulation,1)) * 100)) : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════
         SECTION LABEL
    ══════════════════════════════════════════ --}}
    <div class="flex items-center gap-3">
        <div class="w-1 h-5 bg-brgyGreen rounded-full"></div>
        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Population Analytics</p>
    </div>

    {{-- ══════════════════════════════════════════
         ROW 1 — Registration Trend (wide) + Gender + Voter
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Registration Trend — spans 2 cols --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm p-7">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-700">New Resident Registrations</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Monthly trend — last 6 months</p>
                </div>
                <span class="px-3 py-1.5 bg-blue-50 text-blue-600 text-[9px] font-black uppercase tracking-widest rounded-xl">Trend</span>
            </div>
            <div class="h-[220px]">
                <canvas id="registrationTrendChart"></canvas>
            </div>
        </div>

        {{-- Gender Doughnut --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7">
            <div class="mb-4">
                <h3 class="text-sm font-extrabold text-slate-700">Gender Distribution</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Male vs Female breakdown</p>
            </div>
            <div class="h-[220px]">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         ROW 2 — Civil Status + Voter + Age Groups
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Civil Status --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7">
            <div class="mb-4">
                <h3 class="text-sm font-extrabold text-slate-700">Civil Status</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Single, Married, Widowed, etc.</p>
            </div>
            <div class="h-[220px]">
                <canvas id="civilStatusChart"></canvas>
            </div>
        </div>

        {{-- Voter Eligibility --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7">
            <div class="mb-4">
                <h3 class="text-sm font-extrabold text-slate-700">Voting Eligibility</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Registered voters vs non-voters</p>
            </div>
            <div class="h-[220px]">
                <canvas id="voterChart"></canvas>
            </div>
        </div>

        {{-- Age Groups --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7">
            <div class="mb-5">
                <h3 class="text-sm font-extrabold text-slate-700">Population by Age Group</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Distribution across life stages</p>
            </div>
            @php $maxAge = max(array_values($ageGroups)) ?: 1; @endphp
            <div class="space-y-4">
                @foreach($ageGroups as $label => $count)
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-[10px] font-bold text-slate-500">{{ $label }}</span>
                        <span class="text-[10px] font-extrabold text-brgyGreen">{{ $count }}</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brgyGreen rounded-full transition-all duration-700"
                             style="width: {{ round($count / $maxAge * 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION LABEL
    ══════════════════════════════════════════ --}}
    <div class="flex items-center gap-3">
        <div class="w-1 h-5 bg-amber-400 rounded-full"></div>
        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">Document Request Analytics</p>
    </div>

    {{-- ══════════════════════════════════════════
         ROW 3 — Doc by Type + Doc by Status + Quick Links
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Doc by Type — spans 2 cols --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm p-7">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-700">Requests by Document Type</h3>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">Most requested documents from residents</p>
                </div>
                <span class="px-3 py-1.5 bg-amber-50 text-amber-600 text-[9px] font-black uppercase tracking-widest rounded-xl">Documents</span>
            </div>
            <div class="h-[220px]">
                <canvas id="docTypeChart"></canvas>
            </div>
        </div>

        {{-- Doc by Status --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7">
            <div class="mb-4">
                <h3 class="text-sm font-extrabold text-slate-700">Request Status</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Current pipeline at a glance</p>
            </div>
            <div class="h-[180px]">
                <canvas id="docStatusChart"></canvas>
            </div>
            {{-- Quick action links --}}
            <div class="mt-5 grid grid-cols-1 gap-2">
                <a href="{{ route('admin.documents.index') }}"
                   class="flex items-center justify-between px-4 py-3 bg-amber-50 hover:bg-amber-100 rounded-2xl transition-colors group">
                    <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Pending Requests</span>
                    <span class="text-lg font-extrabold text-amber-600">{{ $pendingRequests }}</span>
                </a>
                <a href="{{ route('admin.schedules.index') }}"
                   class="flex items-center justify-between px-4 py-3 bg-blue-50 hover:bg-blue-100 rounded-2xl transition-colors group">
                    <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest">Upcoming Events</span>
                    <span class="text-lg font-extrabold text-blue-600">{{ \App\Models\Schedule::where('schedule_date', '>=', now()->toDateString())->count() }}</span>
                </a>
                <a href="{{ route('admin.reports.index') }}"
                   class="flex items-center justify-between px-4 py-3 bg-red-50 hover:bg-red-100 rounded-2xl transition-colors group">
                    <span class="text-[10px] font-black text-red-700 uppercase tracking-widest">Open Complaints</span>
                    <span class="text-lg font-extrabold text-red-600">{{ \App\Models\Complaint::where('status', 'open')->count() }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         ROW 4 — Recent Activity + Barangay Council
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Audit Log — spans 2 cols, role 1 only --}}
        @if(auth()->user()->role === 1 && $recentLogs->isNotEmpty())
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-7 py-5 border-b border-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-5 bg-purple-400 rounded-full"></div>
                    <h3 class="text-sm font-extrabold text-slate-700">Recent Activity</h3>
                </div>
                <a href="{{ route('admin.audit-logs.index') }}"
                   class="text-[9px] font-black uppercase tracking-widest text-brgyGreen hover:underline">
                    View All →
                </a>
            </div>
            <div class="divide-y divide-slate-50 max-h-[380px] overflow-y-auto custom-scrollbar">
                @php
                    $actionColors = [
                        'created'        => ['bg'=>'bg-green-100',  'text'=>'text-green-700',  'dot'=>'bg-green-400'],
                        'updated'        => ['bg'=>'bg-blue-100',   'text'=>'text-blue-700',   'dot'=>'bg-blue-400'],
                        'deleted'        => ['bg'=>'bg-red-100',    'text'=>'text-red-700',    'dot'=>'bg-red-400'],
                        'status_changed' => ['bg'=>'bg-amber-100',  'text'=>'text-amber-700',  'dot'=>'bg-amber-400'],
                        'role_changed'   => ['bg'=>'bg-purple-100', 'text'=>'text-purple-700', 'dot'=>'bg-purple-400'],
                        'login'          => ['bg'=>'bg-teal-100',   'text'=>'text-teal-700',   'dot'=>'bg-teal-400'],
                        'logout'         => ['bg'=>'bg-slate-100',  'text'=>'text-slate-600',  'dot'=>'bg-slate-300'],
                    ];
                @endphp
                @foreach($recentLogs as $log)
                @php $c = $actionColors[$log->action] ?? ['bg'=>'bg-slate-100','text'=>'text-slate-600','dot'=>'bg-slate-300']; @endphp
                <div class="px-7 py-3.5 flex items-center gap-4 hover:bg-slate-50/60 transition-colors">
                    <div class="w-2 h-2 rounded-full {{ $c['dot'] }} flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-700 truncate">
                            <span class="{{ $c['text'] }} font-black">{{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'Unknown' }}</span>
                            <span class="font-medium text-slate-400"> {{ str_replace('_', ' ', $log->action) }} </span>
                            <span class="text-slate-600">{{ $log->subject_label }}</span>
                        </p>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="flex-shrink-0 px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $c['bg'] }} {{ $c['text'] }}">
                        {{ str_replace('_', ' ', $log->action) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="lg:col-span-2"></div>
        @endif

        {{-- Barangay Council --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                <div class="w-1 h-5 bg-brgyGreen rounded-full"></div>
                <h3 class="text-sm font-extrabold text-slate-700">Barangay Council</h3>
            </div>
            <div class="divide-y divide-slate-50 max-h-[380px] overflow-y-auto custom-scrollbar">
                <div class="px-6 py-4 bg-brgyGreen/5 border-l-4 border-brgyGreen">
                    <p class="text-xs font-extrabold text-slate-800 uppercase tracking-tight">Erwin R. Molina</p>
                    <p class="text-[9px] text-brgyGreen font-black uppercase tracking-widest mt-0.5">Punong Barangay</p>
                </div>
                @php
                    $officials = [
                        ['Victoria S. Burlaos',      'Secretary'],
                        ['Romeo R. De Leon',          'Treasurer'],
                        ['John Carlo C. Solomon',     'Kagawad — Appropriations'],
                        ['Reynaldo J. Dauz Jr.',      'Kagawad — Peace & Order'],
                        ['Jesus C. Anunciacion',      'Kagawad — Rules & Education'],
                        ['Claudine A. Dizon',         'Kagawad — Livelihood'],
                        ['Ian M. Perez',              'Kagawad — Health'],
                        ['Ma. Teresita G. Quintana',  'Kagawad — Environment'],
                        ['Enerson R. Molina',         'Kagawad — Entrepreneurship'],
                        ['Alaine Joy T. Ambito',      'Chairperson — SK'],
                        ['Rustico B. Cuevas Jr.',     'Executive Officer — BSG'],
                    ];
                @endphp
                @foreach($officials as $official)
                <div class="px-6 py-3 hover:bg-slate-50 transition-colors group">
                    <p class="text-xs font-bold text-slate-700 group-hover:text-brgyGreen transition-colors">{{ $official[0] }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter mt-0.5">{{ $official[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     CHART.JS SCRIPTS
══════════════════════════════════════════ --}}
<script>
const chartDefaults = {
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: { usePointStyle: true, padding: 16, font: { size: 11, weight: 'bold' }, color: '#64748b' }
        }
    }
};

// Registration Trend
new Chart(document.getElementById('registrationTrendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($registrationTrend->keys()) !!},
        datasets: [{
            label: 'New Residents',
            data: {!! json_encode($registrationTrend->values()) !!},
            borderColor: '#1d4ed8',
            backgroundColor: 'rgba(29,78,216,0.07)',
            borderWidth: 2.5,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#1d4ed8',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10, weight: 'bold' }, color: '#94a3b8' }, grid: { color: '#f1f5f9' }, border: { display: false } },
            x: { ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' }, grid: { display: false }, border: { display: false } }
        }
    }
});

// Gender Doughnut
new Chart(document.getElementById('genderChart'), {
    type: 'doughnut',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{ data: [{{ $maleCount }}, {{ $femaleCount }}], backgroundColor: ['#38bdf8', '#f472b6'], borderWidth: 0, hoverOffset: 5 }]
    },
    options: { ...chartDefaults, cutout: '68%' }
});

// Voter Pie
new Chart(document.getElementById('voterChart'), {
    type: 'doughnut',
    data: {
        labels: ['Registered Voters', 'Non-Voters'],
        datasets: [{ data: [{{ $voterCount }}, {{ $totalPopulation - $voterCount }}], backgroundColor: ['#f59e0b', '#e2e8f0'], borderWidth: 0, hoverOffset: 5 }]
    },
    options: { ...chartDefaults, cutout: '68%' }
});

// Civil Status
new Chart(document.getElementById('civilStatusChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($civilStatusData->keys()) !!},
        datasets: [{ data: {!! json_encode($civilStatusData->values()) !!}, backgroundColor: ['#6366f1','#f59e0b','#10b981','#f43f5e','#8b5cf6'], borderWidth: 0, hoverOffset: 5 }]
    },
    options: { ...chartDefaults, cutout: '68%' }
});

// Document Requests by Type (horizontal bar)
new Chart(document.getElementById('docTypeChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($docByType->keys()) !!},
        datasets: [{
            label: 'Requests',
            data: {!! json_encode($docByType->values()) !!},
            backgroundColor: 'rgba(29,78,216,0.15)',
            borderColor: '#1d4ed8',
            borderWidth: 1.5,
            borderRadius: 6,
            borderSkipped: false
        }]
    },
    options: {
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10, weight: 'bold' }, color: '#94a3b8' }, grid: { color: '#f1f5f9' }, border: { display: false } },
            y: { ticks: { font: { size: 10, weight: 'bold' }, color: '#64748b' }, grid: { display: false }, border: { display: false } }
        }
    }
});

// Document Status Doughnut
const statusColors = { 'pending':'#f59e0b','approved':'#10b981','rejected':'#f43f5e','released':'#6366f1','cancelled':'#94a3b8' };
const statusLabels = {!! json_encode($docByStatus->keys()) !!};
new Chart(document.getElementById('docStatusChart'), {
    type: 'doughnut',
    data: {
        labels: statusLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
        datasets: [{ data: {!! json_encode($docByStatus->values()) !!}, backgroundColor: statusLabels.map(l => statusColors[l] ?? '#94a3b8'), borderWidth: 0, hoverOffset: 5 }]
    },
    options: { ...chartDefaults, cutout: '68%' }
});
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #1d4ed8; }
</style>
@endsection
