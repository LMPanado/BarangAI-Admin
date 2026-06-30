@extends('layouts.admin')

@section('content')
{{-- Load Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">{{ now()->format('l, F j, Y') }}</p>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Real-time statistics and barangay council directory.</p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-barangayGreen">Dashboard</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Residents</p>
                <div class="p-2 bg-green-50 rounded-lg text-barangayGreen">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline mt-4">
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalPopulation }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Male</p>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">{{ $maleCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Female</p>
                <div class="p-2 bg-pink-50 rounded-lg text-pink-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">{{ $femaleCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Registered Voters</p>
                <div class="p-2 bg-amber-50 rounded-lg text-amber-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">{{ $voterCount }}</p>
        </div>
    </div>

    {{-- START OF NEW GRAPH SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-6">Population by Gender</h3>
            <div class="h-[250px]">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-6">Voting Eligibility</h3>
            <div class="h-[250px]">
                <canvas id="voterChart"></canvas>
            </div>
        </div>
    </div>
    {{-- END OF NEW GRAPH SECTION --}}

    {{-- NEW CHARTS ROW 2: Civil Status + Registration Trend --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-1">Civil Status</h3>
            <p class="text-[10px] text-gray-400 font-medium mb-6">Breakdown of residents by civil status</p>
            <div class="h-[250px]">
                <canvas id="civilStatusChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-1">New Resident Registrations</h3>
            <p class="text-[10px] text-gray-400 font-medium mb-6">Monthly trend over the last 6 months</p>
            <div class="h-[250px]">
                <canvas id="registrationTrendChart"></canvas>
            </div>
        </div>
    </div>

    {{-- NEW CHARTS ROW 3: Document Requests by Type + by Status --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-1">Document Requests by Type</h3>
            <p class="text-[10px] text-gray-400 font-medium mb-6">Which documents residents request the most</p>
            <div class="h-[280px]">
                <canvas id="docTypeChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-1">Document Request Status</h3>
            <p class="text-[10px] text-gray-400 font-medium mb-6">Current status of all document requests</p>
            <div class="h-[280px]">
                <canvas id="docStatusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Audit Log Feed (role 1 only) --}}
    @if(auth()->user()->role === 1 && $recentLogs->isNotEmpty())
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-gray-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-gray-50 rounded-xl">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider">Recent Activity</h3>
            </div>
            <a href="{{ route('admin.audit-logs.index') }}"
               class="text-[10px] font-black uppercase tracking-widest text-brgyGreen hover:underline">
                View All →
            </a>
        </div>
        <div class="divide-y divide-gray-50">
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
            @foreach($recentLogs as $log)
            @php $c = $actionColors[$log->action] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-600']; @endphp
            <div class="px-8 py-4 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="shrink-0 w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->subjectIcon() }}"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-gray-800 truncate">
                        <span class="{{ $c['text'] }} font-black">{{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'Unknown' }}</span>
                        <span class="font-medium text-gray-500"> {{ str_replace('_', ' ', $log->action) }} </span>
                        <span class="text-gray-700">{{ $log->subject_label }}</span>
                    </p>
                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                </div>
                <span class="shrink-0 px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $c['bg'] }} {{ $c['text'] }}">
                    {{ str_replace('_', ' ', $log->action) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-white px-8 py-5 border-b border-gray-50">
                <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider">Population by Age Group</h3>
            </div>
            <div class="p-8 space-y-5">
                @php $maxAge = max(array_values($ageGroups)) ?: 1; @endphp
                @foreach($ageGroups as $label => $count)
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-gray-600">{{ $label }}</span>
                        <span class="text-xs font-extrabold text-brgyGreen">{{ $count }}</span>
                    </div>
                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brgyGreen rounded-full transition-all duration-500"
                             style="width: {{ $maxAge > 0 ? round($count / $maxAge * 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach

                <div class="pt-4 border-t border-gray-50 grid grid-cols-3 gap-4">
                    <a href="{{ route('admin.documents.index') }}"
                       class="flex flex-col items-center p-4 bg-amber-50 rounded-2xl hover:bg-amber-100 transition-colors group">
                        <p class="text-2xl font-extrabold text-amber-700">{{ $pendingRequests }}</p>
                        <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mt-1 text-center">Pending Requests</p>
                    </a>
                    <a href="{{ route('admin.schedules.index') }}"
                       class="flex flex-col items-center p-4 bg-blue-50 rounded-2xl hover:bg-blue-100 transition-colors group">
                        <p class="text-2xl font-extrabold text-blue-700">{{ \App\Models\Schedule::where('schedule_date', '>=', now()->toDateString())->count() }}</p>
                        <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mt-1 text-center">Upcoming Events</p>
                    </a>
                    <a href="{{ route('admin.reports.index') }}"
                       class="flex flex-col items-center p-4 bg-red-50 rounded-2xl hover:bg-red-100 transition-colors group">
                        <p class="text-2xl font-extrabold text-red-700">{{ \App\Models\Complaint::where('status', 'open')->count() }}</p>
                        <p class="text-[9px] font-black text-red-600 uppercase tracking-widest mt-1 text-center">Open Complaints</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-barangayGreen px-6 py-5">
                <h3 class="text-sm font-extrabold text-white uppercase tracking-wider">Barangay Council</h3>
            </div>
            <div class="divide-y divide-gray-50 max-h-[440px] overflow-y-auto custom-scrollbar">
                <div class="p-6 bg-green-50/50 border-l-4 border-barangayGreen">
                    <p class="text-sm font-extrabold text-gray-900 tracking-tight uppercase">Erwin R. Molina</p>
                    <p class="text-[10px] text-barangayGreen font-bold uppercase tracking-widest mt-0.5">Punong Barangay</p>
                </div>

                @php
                    $officials = [
                        ['Victoria S. Burlaos', 'Secretary'],
                        ['Romeo R. De Leon', 'Treasurer'],
                        ['John Carlo C. Solomon', 'Kagawad (Appropriations)'],
                        ['Reynaldo J. Dauz Jr.', 'Kagawad (Peace & Order)'],
                        ['Jesus C. Anunciacion', 'Kagawad (Rules & Education)'],
                        ['Claudine A. Dizon', 'Kagawad (Livelihood)'],
                        ['Ian M. Perez', 'Kagawad (Health)'],
                        ['Ma. Teresita G. Quintana', 'Kagawad (Environment)'],
                        ['Enerson R. Molina', 'Kagawad (Entrepreneurship)'],
                        ['Alaine Joy T. Ambito', 'Chairperson (SK)'],
                        ['Rustico B. Cuevas Jr.', 'Executive Officer (BSG)'],
                    ];
                @endphp

                @foreach($officials as $official)
                <div class="p-4 hover:bg-gray-50 transition-colors px-6 group">
                    <p class="text-xs font-bold text-gray-800 group-hover:text-barangayGreen transition-colors">{{ $official[0] }}</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter mt-0.5">{{ $official[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // Gender Chart Configuration
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: ['#3b82f6', '#ec4899'],
                hoverOffset: 4,
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 11, weight: 'bold' } } }
            },
            cutout: '70%'
        }
    });

    // Voter Chart Configuration
    new Chart(document.getElementById('voterChart'), {
        type: 'pie',
        data: {
            labels: ['Voters', 'Non-Voters'],
            datasets: [{
                data: [{{ $voterCount }}, {{ $totalPopulation - $voterCount }}],
                backgroundColor: ['#f59e0b', '#e2e8f0'],
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 11, weight: 'bold' } } }
            }
        }
    });

    // Civil Status Chart
    new Chart(document.getElementById('civilStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($civilStatusData->keys()) !!},
            datasets: [{
                data: {!! json_encode($civilStatusData->values()) !!},
                backgroundColor: ['#6366f1', '#f59e0b', '#10b981', '#f43f5e', '#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 11, weight: 'bold' } } }
            },
            cutout: '65%'
        }
    });

    // Registration Trend Chart (last 6 months)
    new Chart(document.getElementById('registrationTrendChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($registrationTrend->keys()) !!},
            datasets: [{
                label: 'New Residents',
                data: {!! json_encode($registrationTrend->values()) !!},
                borderColor: '#1d4ed8',
                backgroundColor: 'rgba(29,78,216,0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#1d4ed8',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 10, weight: 'bold' } },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { font: { size: 10, weight: 'bold' } },
                    grid: { display: false }
                }
            }
        }
    });

    // Document Requests by Type
    new Chart(document.getElementById('docTypeChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($docByType->keys()) !!},
            datasets: [{
                label: 'Requests',
                data: {!! json_encode($docByType->values()) !!},
                backgroundColor: '#1d4ed8',
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 10, weight: 'bold' } },
                    grid: { color: '#f1f5f9' }
                },
                y: {
                    ticks: { font: { size: 10, weight: 'bold' } },
                    grid: { display: false }
                }
            }
        }
    });

    // Document Requests by Status
    const statusColors = {
        'pending':   '#f59e0b',
        'approved':  '#10b981',
        'rejected':  '#f43f5e',
        'released':  '#6366f1',
        'cancelled': '#94a3b8',
    };
    const statusLabels = {!! json_encode($docByStatus->keys()) !!};
    new Chart(document.getElementById('docStatusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
            datasets: [{
                data: {!! json_encode($docByStatus->values()) !!},
                backgroundColor: statusLabels.map(l => statusColors[l] ?? '#94a3b8'),
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 11, weight: 'bold' } } }
            },
            cutout: '65%'
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #1d4ed8; }
</style>
@endsection
