@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-[1600px] mx-auto pb-12" id="report-content">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6 no-print">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Barangay Reports</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Monthly analytics for <span class="text-brgyGreen font-bold not-italic">Barangay 419</span>.
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Dashboard</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Reports</span>
        </nav>
    </div>

    {{-- Controls --}}
    <div class="flex items-center justify-between no-print">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-center gap-3">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Month</label>
            <input type="month" name="month" value="{{ $month }}"
                   class="bg-white border-2 border-gray-100 rounded-2xl px-5 py-2.5 text-sm font-bold text-gray-700 focus:border-brgyGreen outline-none transition-all shadow-sm">
            <button type="submit"
                    class="bg-brgyGreen text-white px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                View
            </button>
        </form>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.export-csv', ['month' => $month]) }}"
               class="flex items-center gap-2 text-white px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-sm"
               style="background-color: #059669;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
            <button onclick="window.open('{{ route('admin.reports.print', ['month' => $month]) }}', '_blank')"
                    class="flex items-center gap-2 bg-gray-800 text-white px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-900 transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>
    </div>

    {{-- Print Header --}}
    <div class="print-only hidden text-center border-b-2 border-gray-800 pb-4 mb-2">
        <h1 class="text-xl font-black text-gray-900 uppercase tracking-widest">Barangay 419</h1>
        <p class="text-sm font-bold text-gray-600 mt-0.5">Monthly Barangay Report — {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
        <p class="text-[10px] text-gray-400 mt-0.5">Generated: {{ now()->format('F d, Y \a\t h:i A') }}</p>
    </div>

    {{-- Period Banner --}}
    <div class="flex items-center gap-3 bg-brgyGreen/5 border border-brgyGreen/20 rounded-2xl px-6 py-3.5">
        <svg class="w-4 h-4 text-brgyGreen shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-xs font-black text-brgyGreen uppercase tracking-widest">
            Showing data for: {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}
        </p>
    </div>

    {{-- At a Glance: 4 key numbers --}}
    <div class="grid grid-cols-4 gap-4">
        @php
        $glance = [
            ['label' => 'Total Residents',   'value' => $totalResidents,    'sub' => $newResidents . ' new this month',          'color' => 'text-gray-800',  'dot' => 'bg-gray-400'],
            ['label' => 'Document Requests', 'value' => $allTimeDocs,       'sub' => $pendingDocs . ' pending this month',        'color' => 'text-blue-700',  'dot' => 'bg-blue-400'],
            ['label' => 'Complaints',        'value' => $allTimeComplaints, 'sub' => $openComplaints . ' open this month',        'color' => 'text-amber-700', 'dot' => 'bg-amber-400'],
            ['label' => 'Feedback',          'value' => $allTimeFeedback,   'sub' => $positiveFeedback . ' positive this month',  'color' => 'text-green-700', 'dot' => 'bg-green-400'],
        ];
        @endphp
        @foreach($glance as $g)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-2 h-2 rounded-full {{ $g['dot'] }}"></span>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $g['label'] }}</p>
            </div>
            <p class="text-3xl font-extrabold {{ $g['color'] }} leading-none">{{ $g['value'] }}</p>
            <p class="text-[10px] text-gray-400 font-semibold mt-2">{{ $g['sub'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Detail Sections: 2x2 grid --}}
    <div class="grid grid-cols-2 gap-6">

        {{-- Population --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-7 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Population</h2>
                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $totalResidents }} total</span>
            </div>
            <div class="p-7 space-y-4">
                <div class="flex items-center gap-6">
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-blue-600">{{ $maleCount }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">Male</p>
                    </div>
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        @php $malePct = $totalResidents > 0 ? round(($maleCount / $totalResidents) * 100) : 0; @endphp
                        <div class="h-full bg-blue-400 rounded-full" style="width: {{ $malePct }}%"></div>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-pink-500">{{ $femaleCount }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">Female</p>
                    </div>
                </div>
                <div class="border-t border-gray-50 pt-4 space-y-2.5">
                    @foreach($ageGroups as $label => $count)
                    @php $pct = $totalResidents > 0 ? round(($count / $totalResidents) * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-bold text-gray-500 w-28 shrink-0">{{ $label }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-1.5">
                            <div class="bg-brgyGreen h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-[10px] font-black text-gray-600 w-6 text-right">{{ $count }}</span>
                        <span class="text-[10px] text-gray-300 w-8">{{ $pct }}%</span>
                    </div>
                    @endforeach
                </div>
                @if($newResidents > 0)
                <div class="pt-3 border-t border-gray-50">
                    <p class="text-[10px] font-bold text-gray-400">New this month: <span class="text-brgyGreen font-black">{{ $newResidents }}</span></p>
                </div>
                @endif
            </div>
        </div>

        {{-- Document Requests --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-7 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Document Requests</h2>
                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $totalDocs }} total</span>
            </div>
            <div class="p-7 space-y-4">
                <div class="grid grid-cols-3 gap-3">
                    @foreach([['Pending', $pendingDocs, 'text-amber-600', 'bg-amber-50'], ['Approved', $approvedDocs, 'text-green-600', 'bg-green-50'], ['Rejected', $rejectedDocs, 'text-red-600', 'bg-red-50']] as [$lbl, $val, $clr, $bg])
                    <div class="rounded-xl {{ $bg }} px-4 py-3 text-center">
                        <p class="text-xl font-extrabold {{ $clr }}">{{ $val }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">{{ $lbl }}</p>
                    </div>
                    @endforeach
                </div>
                @if($docsByType->isNotEmpty())
                <div class="border-t border-gray-50 pt-4 space-y-2.5">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3">By document type</p>
                    @foreach($docsByType as $doc)
                    @php $pct = $totalDocs > 0 ? round(($doc->total / $totalDocs) * 100) : 0; @endphp
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-bold text-gray-500 w-36 shrink-0 capitalize truncate">{{ str_replace('_', ' ', $doc->document_type) }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-1.5">
                            <div class="bg-blue-400 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-[10px] font-black text-gray-600 w-6 text-right">{{ $doc->total }}</span>
                        <span class="text-[10px] text-gray-300 w-8">{{ $pct }}%</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-gray-300 font-bold text-center py-4">No requests this month.</p>
                @endif
            </div>
        </div>

        {{-- Complaints --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-7 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Complaints</h2>
                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $totalComplaints }} total</span>
            </div>
            <div class="p-7">
                <div class="grid grid-cols-3 gap-3">
                    @foreach([['Open', $openComplaints, 'text-amber-600', 'bg-amber-50'], ['Closed', $closedComplaints, 'text-green-600', 'bg-green-50'], ['Critical', $criticalComplaints, 'text-red-600', 'bg-red-50']] as [$lbl, $val, $clr, $bg])
                    <div class="rounded-xl {{ $bg }} px-4 py-5 text-center">
                        <p class="text-2xl font-extrabold {{ $clr }}">{{ $val }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $lbl }}</p>
                    </div>
                    @endforeach
                </div>
                @if($totalComplaints > 0)
                <div class="mt-5 pt-4 border-t border-gray-50">
                    @php $resolvedPct = $totalComplaints > 0 ? round(($closedComplaints / $totalComplaints) * 100) : 0; @endphp
                    <div class="flex items-center justify-between mb-1.5">
                        <p class="text-[10px] font-bold text-gray-400">Resolution rate</p>
                        <p class="text-[10px] font-black text-green-600">{{ $resolvedPct }}%</p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-400 h-2 rounded-full" style="width: {{ $resolvedPct }}%"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Feedback --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-7 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Resident Feedback</h2>
                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $totalFeedback }} total</span>
            </div>
            <div class="p-7">
                <div class="grid grid-cols-2 gap-3">
                    @foreach([['Positive', $positiveFeedback, 'text-green-600', 'bg-green-50'], ['Negative', $negativeFeedback, 'text-red-600', 'bg-red-50']] as [$lbl, $val, $clr, $bg])
                    <div class="rounded-xl {{ $bg }} px-4 py-5 text-center">
                        <p class="text-2xl font-extrabold {{ $clr }}">{{ $val }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $lbl }}</p>
                    </div>
                    @endforeach
                </div>
                @if($totalFeedback > 0)
                <div class="mt-5 pt-4 border-t border-gray-50">
                    @php $posPct = $totalFeedback > 0 ? round(($positiveFeedback / $totalFeedback) * 100) : 0; @endphp
                    <div class="flex items-center justify-between mb-1.5">
                        <p class="text-[10px] font-bold text-gray-400">Satisfaction rate</p>
                        <p class="text-[10px] font-black text-green-600">{{ $posPct }}%</p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-400 h-2 rounded-full" style="width: {{ $posPct }}%"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Print Footer --}}
    <div class="print-only hidden border-t-2 border-gray-200 pt-4 mt-4 text-center">
        <p class="text-[10px] text-gray-400">Generated from the Barangay 419 Admin Portal · {{ now()->format('F d, Y') }}</p>
    </div>

</div>

<style>
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    body { background: white !important; }
    #report-content { max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
    .bg-white { box-shadow: none !important; }
    @page { size: A4; margin: 20mm; }
}
</style>
@endsection
