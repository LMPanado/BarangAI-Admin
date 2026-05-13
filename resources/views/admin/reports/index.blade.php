@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-2 pb-12">
    
    {{-- Page Header --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 pb-2">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 bg-brgyGold rounded-full"></div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Incident Analytics</h1>
            </div>
            <p class="text-slate-500 text-sm font-medium ml-5">
                Monthly trends and blotter records for <span class="text-brgyGreen font-bold">Barangay 419</span>.
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <button onclick="window.print()" class="px-6 py-3.5 bg-white border-2 border-slate-100 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <svg class="h-4 w-4 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>
    </div>

    {{-- Analytics Graph --}}
    <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 relative overflow-hidden">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Yearly Incident Trend</h3>
            <div class="w-12 h-1 bg-slate-50 rounded-full"></div>
        </div>
        <div class="h-[350px] w-full">
            <canvas id="incidentChart"></canvas>
        </div>
    </div>

    {{-- Incident List Container --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Recent Incident Logs</h3>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" placeholder="FILTER RECORDS..." class="pl-10 pr-6 py-3 text-[10px] font-black uppercase tracking-widest border-2 border-slate-100 rounded-xl focus:border-brgyGreen focus:ring-0 outline-none w-64 transition-all bg-white shadow-sm placeholder:text-slate-300">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                        <th class="px-8 py-6">Incident Details</th>
                        <th class="px-8 py-6">Parties Involved</th>
                        <th class="px-8 py-6">Schedule</th>
                        <th class="px-8 py-6">Location & Status</th>
                        <th class="px-8 py-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $placeholders = [
                            ['type' => 'Physical Altercation', 'comp' => 'Juan Dela Cruz', 'resp' => 'Pedro Penduko', 'victim' => 'Serafin Gomez', 'status' => 'Pending', 'color' => 'amber'],
                            ['type' => 'Theft / Robbery', 'comp' => 'Maria Clara', 'resp' => 'Unknown', 'victim' => 'Maria Clara', 'status' => 'Resolved', 'color' => 'emerald'],
                            ['type' => 'Noise Complaint', 'comp' => 'Ricardo Dalisay', 'resp' => 'Neighbors', 'victim' => 'Community', 'status' => 'Mediation', 'color' => 'blue']
                        ];
                    @endphp

                    @foreach($placeholders as $row)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="font-bold text-slate-800 text-base leading-tight group-hover:text-brgyGreen transition-colors italic mb-1">
                                {{ $row['type'] }}
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="w-1 h-1 bg-brgyGold rounded-full"></span>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 font-mono">
                                    CASE ID: #2026-00{{ $loop->iteration }}
                                </p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-[8px] font-black text-brgyGreen uppercase bg-brgyGreen/5 px-1.5 py-0.5 rounded">Comp</span>
                                    <p class="text-[11px] font-bold text-slate-600 uppercase">{{ $row['comp'] }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[8px] font-black text-rose-400 uppercase bg-rose-50 px-1.5 py-0.5 rounded">Resp</span>
                                    <p class="text-[11px] font-bold text-slate-600 uppercase">{{ $row['resp'] }}</p>
                                </div>
                                <p class="text-[9px] font-black text-slate-400 uppercase italic mt-1 ml-1">Victim: {{ $row['victim'] }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-bold text-slate-600 uppercase">Feb 27, 2026</span>
                            </div>
                            <p class="text-[9px] font-black text-slate-400 tracking-widest uppercase mt-1 ml-5">08:45 PM</p>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-2 text-slate-500">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Brgy. 419, Zone 43</span>
                                </div>
                                <span class="w-fit px-4 py-1.5 bg-{{ $row['color'] }}-50 text-{{ $row['color'] }}-600 border border-{{ $row['color'] }}-100 rounded-xl text-[9px] font-black uppercase tracking-widest">
                                    {{ $row['status'] }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                             <div class="flex items-center justify-end">
                                <button class="p-2.5 bg-slate-50 text-slate-400 hover:bg-brgyGreen hover:text-white rounded-xl transition-all duration-300 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                             </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Load Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('incidentChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(45, 90, 39, 0.15)');
    gradient.addColorStop(1, 'rgba(45, 90, 39, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Reported Incidents',
                data: {!! json_encode($chartData['data']) !!},
                borderColor: '#2d5a27',
                borderWidth: 5,
                pointBackgroundColor: '#f1c40f',
                pointBorderColor: '#fff',
                pointBorderWidth: 4,
                pointRadius: 6,
                tension: 0.4,
                fill: true,
                backgroundColor: gradient,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e3d1a',
                    titleFont: { size: 10, weight: 'bold', family: 'Inter' },
                    bodyFont: { size: 13, weight: '900', family: 'Inter' },
                    padding: 15,
                    cornerRadius: 15,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                    ticks: { font: { size: 10, weight: '900' }, color: '#94a3b8' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10, weight: '900' }, color: '#94a3b8' }
                }
            }
        }
    });
</script>
@endsection