@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-8 pb-12 max-w-[1600px] mx-auto">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Barangay Reports</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Live data from <span class="text-brgyGreen font-bold not-italic">Barangay 419</span> — {{ now()->format('F Y') }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <nav class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-[0.15em] bg-gray-50 px-4 py-2 rounded-full border border-gray-100">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Dashboard</a>
                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-brgyGreen">Reports</span>
            </nav>
            <button onclick="window.print()"
                    class="px-5 py-2.5 bg-white border-2 border-gray-100 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-600 hover:bg-gray-50 transition-all flex items-center gap-2 shadow-sm">
                <svg class="h-4 w-4 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 1 — RESIDENT DEMOGRAPHICS
    ══════════════════════════════════════════ --}}
    <div>
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Resident Demographics</p>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $statCards = [
                    ['label' => 'Total Residents', 'value' => $totalResidents,  'color' => 'green',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Male',            'value' => $maleCount,       'color' => 'blue',   'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['label' => 'Female',          'value' => $femaleCount,     'color' => 'pink',   'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['label' => 'Registered Voters','value'=> $voterCount,      'color' => 'amber',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
                $colorMap = [
                    'green' => ['bg'=>'bg-green-50','text'=>'text-green-600','num'=>'text-brgyGreen'],
                    'blue'  => ['bg'=>'bg-blue-50', 'text'=>'text-blue-600', 'num'=>'text-blue-700'],
                    'pink'  => ['bg'=>'bg-pink-50', 'text'=>'text-pink-600', 'num'=>'text-pink-700'],
                    'amber' => ['bg'=>'bg-amber-50','text'=>'text-amber-600','num'=>'text-amber-700'],
                ];
            @endphp
            @foreach($statCards as $card)
            @php $c = $colorMap[$card['color']]; @endphp
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $card['label'] }}</p>
                    <div class="p-2 {{ $c['bg'] }} rounded-xl">
                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold {{ $c['num'] }} tracking-tight">{{ number_format($card['value']) }}</p>
            </div>
            @endforeach
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Monthly Residents Added --}}
            <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">New Residents Added — {{ now()->year }}</p>
                <div class="h-[220px]">
                    <canvas id="residentChart"></canvas>
                </div>
            </div>

            {{-- Age Groups --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Age Groups</p>
                <div class="space-y-4">
                    @php $maxAge = max(array_values($ageGroups)) ?: 1; @endphp
                    @foreach($ageGroups as $label => $count)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">{{ $label }}</span>
                            <span class="text-xs font-extrabold text-brgyGreen">{{ $count }}</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-brgyGreen rounded-full transition-all"
                                 style="width: {{ $maxAge > 0 ? round($count / $maxAge * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($civilStatus->isNotEmpty())
                <div class="mt-6 pt-6 border-t border-gray-50">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Civil Status</p>
                    <div class="space-y-2">
                        @foreach($civilStatus as $status => $count)
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">{{ $status }}</span>
                            <span class="text-[10px] font-black text-gray-700">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 2 — DOCUMENT REQUESTS
    ══════════════════════════════════════════ --}}
    <div>
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Document Requests</p>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $docCards = [
                    ['label'=>'Total Requests', 'value'=>$totalRequests,    'bg'=>'bg-gray-50',   'num'=>'text-gray-800'],
                    ['label'=>'Pending',        'value'=>$pendingRequests,  'bg'=>'bg-amber-50',  'num'=>'text-amber-700'],
                    ['label'=>'Ready for Pickup','value'=>$readyRequests,   'bg'=>'bg-blue-50',   'num'=>'text-blue-700'],
                    ['label'=>'Released',       'value'=>$releasedRequests, 'bg'=>'bg-green-50',  'num'=>'text-green-700'],
                ];
            @endphp
            @foreach($docCards as $card)
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">{{ $card['label'] }}</p>
                <div class="inline-flex items-center justify-center px-4 py-2 {{ $card['bg'] }} rounded-2xl">
                    <p class="text-3xl font-extrabold {{ $card['num'] }} tracking-tight">{{ number_format($card['value']) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Monthly Request Chart --}}
            <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Requests per Month — {{ now()->year }}</p>
                <div class="h-[220px]">
                    <canvas id="requestChart"></canvas>
                </div>
            </div>

            {{-- By Document Type --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">By Document Type</p>
                @if($requestsByType->isEmpty())
                    <p class="text-[10px] text-gray-300 font-black uppercase tracking-widest text-center py-8">No data yet</p>
                @else
                    @php $maxReq = $requestsByType->max() ?: 1; @endphp
                    <div class="space-y-4">
                        @foreach($requestsByType as $type => $count)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-tight">{{ $type }}</span>
                                <span class="text-xs font-extrabold text-brgyGreen">{{ $count }}</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-brgyGold rounded-full"
                                     style="width: {{ round($count / $maxReq * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 3 — EVENTS & ANNOUNCEMENTS
    ══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Schedules / Events --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Barangay Events</p>
            <div class="grid grid-cols-2 gap-4">
                @php
                    $evCards = [
                        ['label'=>'Total Events',   'value'=>$totalEvents,      'color'=>'text-gray-800',   'bg'=>'bg-gray-50'],
                        ['label'=>'This Month',     'value'=>$thisMonthEvents,  'color'=>'text-brgyGreen',  'bg'=>'bg-green-50'],
                        ['label'=>'Upcoming',       'value'=>$upcomingEvents,   'color'=>'text-blue-700',   'bg'=>'bg-blue-50'],
                        ['label'=>'Past Events',    'value'=>$pastEvents,       'color'=>'text-gray-500',   'bg'=>'bg-gray-50'],
                    ];
                @endphp
                @foreach($evCards as $c)
                <div class="{{ $c['bg'] }} rounded-2xl p-5 text-center">
                    <p class="text-2xl font-extrabold {{ $c['color'] }} tracking-tight">{{ $c['value'] }}</p>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $c['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Announcements --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Announcements</p>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 rounded-2xl p-5 text-center">
                    <p class="text-2xl font-extrabold text-gray-800 tracking-tight">{{ $totalAnnouncements }}</p>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Total Posted</p>
                </div>
                <div class="bg-amber-50 rounded-2xl p-5 text-center">
                    <p class="text-2xl font-extrabold text-amber-700 tracking-tight">{{ $pinnedAnnouncements }}</p>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Pinned</p>
                </div>
            </div>
            @if($announcementsByCategory->isNotEmpty())
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-3">By Category</p>
            @php $maxAnn = $announcementsByCategory->max() ?: 1; @endphp
            <div class="space-y-3">
                @foreach($announcementsByCategory as $cat => $count)
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">{{ $cat }}</span>
                        <span class="text-xs font-extrabold text-brgyGreen">{{ $count }}</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brgyGreen/60 rounded-full"
                             style="width: {{ round($count / $maxAnn * 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECTION 4 — RECENT DOCUMENT REQUESTS TABLE
    ══════════════════════════════════════════ --}}
    <div>
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Recent Document Requests</p>
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            @if($recentRequests->isEmpty())
                <div class="py-16 text-center">
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No requests yet</p>
                </div>
            @else
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50 bg-gray-50/50">
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Resident</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Document Type</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Purpose</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Pickup Date</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentRequests as $req)
                    @php
                        $statusStyle = match($req->status) {
                            'pending'  => 'bg-amber-50 text-amber-700',
                            'ready'    => 'bg-blue-50 text-blue-700',
                            'released' => 'bg-green-50 text-green-700',
                            default    => 'bg-gray-50 text-gray-500',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-gray-800">
                                {{ optional($req->resident)->last_name }}, {{ optional($req->resident)->first_name }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-gray-700">{{ $req->document_type }}</p>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-xs text-gray-500 truncate" title="{{ $req->purpose }}">{{ $req->purpose }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-xs font-bold text-gray-700">{{ \Carbon\Carbon::parse($req->pickup_date)->format('M d, Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                {{ $req->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>

<script>
    const monthLabels = {!! json_encode($monthLabels) !!};

    // Resident chart
    new Chart(document.getElementById('residentChart'), {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'New Residents',
                data: {!! json_encode($residentChartData) !!},
                backgroundColor: 'rgba(45,90,39,0.15)',
                borderColor: '#2d5a27',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0, font: { size: 10, weight: '700' }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,0.03)' } },
                x: { ticks: { font: { size: 10, weight: '700' }, color: '#94a3b8' }, grid: { display: false } }
            }
        }
    });

    // Document requests chart
    new Chart(document.getElementById('requestChart'), {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Requests',
                data: {!! json_encode($requestChartData) !!},
                borderColor: '#f1c40f',
                borderWidth: 3,
                pointBackgroundColor: '#2d5a27',
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointRadius: 5,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(241,196,15,0.08)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0, font: { size: 10, weight: '700' }, color: '#94a3b8' }, grid: { color: 'rgba(0,0,0,0.03)' } },
                x: { ticks: { font: { size: 10, weight: '700' }, color: '#94a3b8' }, grid: { display: false } }
            }
        }
    });
</script>
@endsection
