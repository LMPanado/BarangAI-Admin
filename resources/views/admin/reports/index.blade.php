@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12 max-w-[1600px] mx-auto" id="report-content">

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

    {{-- Month Picker + Generate Button --}}
    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 no-print">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-center gap-3">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Month</label>
            <input type="month" name="month" value="{{ $month }}"
                   class="bg-white border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:border-brgyGreen outline-none transition-all shadow-sm">
            <button type="submit"
                    class="bg-brgyGreen text-white px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                View
            </button>
        </form>

        <button onclick="window.print()"
                class="flex items-center gap-2 bg-gray-800 text-white px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-900 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Generate PDF Report
        </button>
    </div>

    {{-- PDF Print Header (only shows when printing) --}}
    <div class="print-only hidden">
        <div class="text-center border-b-2 border-gray-800 pb-4 mb-6">
            <h1 class="text-2xl font-black text-gray-900 uppercase tracking-widest">Barangay 419</h1>
            <p class="text-sm font-bold text-gray-600 mt-1">Monthly Barangay Report</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
            <p class="text-[10px] text-gray-400 mt-1">Generated: {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>

    {{-- Report Period Label --}}
    <div class="bg-brgyGreen/5 border border-brgyGreen/20 rounded-2xl px-6 py-4">
        <p class="text-xs font-black text-brgyGreen uppercase tracking-widest">
            Report Period: {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}
        </p>
    </div>

    {{-- SECTION 1: Population Overview --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50/50 px-8 py-4 border-b border-gray-100">
            <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">1. Population Overview</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $popCards = [
                        ['label' => 'Total Residents', 'value' => $totalResidents,  'color' => 'text-gray-800',  'bg' => 'bg-gray-50'],
                        ['label' => 'Male',            'value' => $maleCount,        'color' => 'text-blue-700',  'bg' => 'bg-blue-50'],
                        ['label' => 'Female',          'value' => $femaleCount,      'color' => 'text-pink-700',  'bg' => 'bg-pink-50'],
                        ['label' => 'Registered Voters','value' => $voterCount,     'color' => 'text-green-700', 'bg' => 'bg-green-50'],
                    ];
                @endphp
                @foreach($popCards as $card)
                <div class="rounded-2xl border border-gray-100 p-5 text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">{{ $card['label'] }}</p>
                    <div class="inline-flex items-center justify-center px-4 py-1.5 {{ $card['bg'] }} rounded-xl">
                        <p class="text-3xl font-extrabold {{ $card['color'] }}">{{ $card['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Age Groups --}}
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Age Group Breakdown</p>
                <div class="space-y-3">
                    @foreach($ageGroups as $label => $count)
                    @php $pct = $totalResidents > 0 ? round(($count / $totalResidents) * 100) : 0; @endphp
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold text-gray-600 w-36 shrink-0">{{ $label }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-2.5">
                            <div class="bg-brgyGreen h-2.5 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-xs font-black text-gray-700 w-10 text-right">{{ $count }}</span>
                        <span class="text-[10px] text-gray-400 w-8">{{ $pct }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($newResidents > 0)
            <div class="mt-6 pt-6 border-t border-gray-50">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                    New residents registered this month:
                    <span class="text-brgyGreen text-sm ml-2">{{ $newResidents }}</span>
                </p>
            </div>
            @endif
        </div>
    </div>

    {{-- SECTION 2: Document Requests --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50/50 px-8 py-4 border-b border-gray-100">
            <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">2. Document Requests This Month</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $docCards = [
                        ['label' => 'Total Requests', 'value' => $totalDocs,    'color' => 'text-gray-800',   'bg' => 'bg-gray-50'],
                        ['label' => 'Pending',         'value' => $pendingDocs,  'color' => 'text-amber-700',  'bg' => 'bg-amber-50'],
                        ['label' => 'Approved',        'value' => $approvedDocs, 'color' => 'text-green-700',  'bg' => 'bg-green-50'],
                        ['label' => 'Rejected',        'value' => $rejectedDocs, 'color' => 'text-red-700',    'bg' => 'bg-red-50'],
                    ];
                @endphp
                @foreach($docCards as $card)
                <div class="rounded-2xl border border-gray-100 p-5 text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">{{ $card['label'] }}</p>
                    <div class="inline-flex items-center justify-center px-4 py-1.5 {{ $card['bg'] }} rounded-xl">
                        <p class="text-3xl font-extrabold {{ $card['color'] }}">{{ $card['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            @if($docsByType->isNotEmpty())
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Requests by Document Type</p>
                <div class="space-y-3">
                    @foreach($docsByType as $doc)
                    @php $pct = $totalDocs > 0 ? round(($doc->total / $totalDocs) * 100) : 0; @endphp
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold text-gray-600 w-48 shrink-0 capitalize">{{ str_replace('_', ' ', $doc->document_type) }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-xs font-black text-gray-700 w-10 text-right">{{ $doc->total }}</span>
                        <span class="text-[10px] text-gray-400 w-8">{{ $pct }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <p class="text-xs text-gray-400 font-bold text-center py-6">No document requests for this month.</p>
            @endif
        </div>
    </div>

    {{-- SECTION 3: Complaints --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50/50 px-8 py-4 border-b border-gray-100">
            <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">3. Complaints This Month</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $compCards = [
                        ['label' => 'Total',    'value' => $totalComplaints,    'color' => 'text-gray-800',   'bg' => 'bg-gray-50'],
                        ['label' => 'Open',     'value' => $openComplaints,     'color' => 'text-amber-700',  'bg' => 'bg-amber-50'],
                        ['label' => 'Closed',   'value' => $closedComplaints,   'color' => 'text-green-700',  'bg' => 'bg-green-50'],
                        ['label' => 'Critical', 'value' => $criticalComplaints, 'color' => 'text-red-700',    'bg' => 'bg-red-50'],
                    ];
                @endphp
                @foreach($compCards as $card)
                <div class="rounded-2xl border border-gray-100 p-5 text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">{{ $card['label'] }}</p>
                    <div class="inline-flex items-center justify-center px-4 py-1.5 {{ $card['bg'] }} rounded-xl">
                        <p class="text-3xl font-extrabold {{ $card['color'] }}">{{ $card['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- SECTION 4: Resident Feedback --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50/50 px-8 py-4 border-b border-gray-100">
            <h2 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">4. Resident Feedback This Month</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-3 gap-4">
                @php
                    $fbCards = [
                        ['label' => 'Total',    'value' => $totalFeedback,    'color' => 'text-gray-800',  'bg' => 'bg-gray-50'],
                        ['label' => 'Positive', 'value' => $positiveFeedback, 'color' => 'text-green-700', 'bg' => 'bg-green-50'],
                        ['label' => 'Negative', 'value' => $negativeFeedback, 'color' => 'text-red-700',   'bg' => 'bg-red-50'],
                    ];
                @endphp
                @foreach($fbCards as $card)
                <div class="rounded-2xl border border-gray-100 p-5 text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">{{ $card['label'] }}</p>
                    <div class="inline-flex items-center justify-center px-4 py-1.5 {{ $card['bg'] }} rounded-xl">
                        <p class="text-3xl font-extrabold {{ $card['color'] }}">{{ $card['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Footer for print --}}
    <div class="print-only hidden border-t-2 border-gray-200 pt-4 mt-8 text-center">
        <p class="text-[10px] text-gray-400">This report was generated from the Barangay 419 Admin Portal · {{ now()->format('F d, Y') }}</p>
    </div>

</div>

<style>
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }

    body { background: white !important; font-size: 12px; }

    #report-content {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .bg-white { box-shadow: none !important; border: 1px solid #e5e7eb !important; }

    .rounded-\[2rem\], .rounded-2xl, .rounded-xl, .rounded-full {
        border-radius: 8px !important;
    }

    /* Force page breaks between sections */
    .bg-white.rounded-\[2rem\] { page-break-inside: avoid; margin-bottom: 16px; }

    @page {
        size: A4;
        margin: 20mm;
    }
}
</style>
@endsection
