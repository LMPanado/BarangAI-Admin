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
            <button onclick="window.print()"
                    class="flex items-center gap-2 bg-gray-800 text-white px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-900 transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>
    </div>

    {{-- Print-only full layout (replaces everything on print) --}}
    @php
        $reportMonth = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
        $resolvedPct = $totalComplaints > 0 ? round(($closedComplaints / $totalComplaints) * 100) : 0;
        $posPct      = $totalFeedback    > 0 ? round(($positiveFeedback / $totalFeedback)    * 100) : 0;
        $malePct     = $totalResidents   > 0 ? round(($maleCount        / $totalResidents)   * 100) : 0;
        $femalePct   = 100 - $malePct;
    @endphp
    <div class="print-only hidden">
        {{-- Cover Header --}}
        <div style="border-bottom: 3px solid #1d4ed8; padding-bottom: 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 18px;">
            <img src="{{ asset('images/brgy_logo.png') }}" style="width: 64px; height: 64px; object-fit: contain;">
            <div>
                <div style="font-size: 20px; font-weight: 900; color: #1e3a8a; letter-spacing: 0.05em; text-transform: uppercase;">Barangay 419</div>
                <div style="font-size: 11px; color: #64748b; font-weight: 600; margin-top: 2px;">Zone 43, District IV · Sampaloc, Manila</div>
                <div style="font-size: 13px; font-weight: 800; color: #1d4ed8; margin-top: 4px;">Monthly Barangay Report — {{ $reportMonth }}</div>
            </div>
            <div style="margin-left: auto; text-align: right;">
                <div style="font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em;">Generated</div>
                <div style="font-size: 10px; font-weight: 700; color: #475569;">{{ now()->format('F d, Y') }}</div>
                <div style="font-size: 10px; color: #94a3b8;">{{ now()->format('h:i A') }}</div>
            </div>
        </div>

        {{-- Summary Cards Row --}}
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px;">
            @foreach([
                ['Total Residents',   $totalResidents,    $newResidents . ' new this month',        '#1e3a8a', '#eff6ff'],
                ['Document Requests', $allTimeDocs,       $pendingDocs  . ' pending this month',    '#1d4d9a', '#eff6ff'],
                ['Complaints',        $allTimeComplaints, $openComplaints . ' open this month',     '#92400e', '#fffbeb'],
                ['Feedback',          $allTimeFeedback,   $positiveFeedback . ' positive this month','#166534','#f0fdf4'],
            ] as [$lbl, $val, $sub, $clr, $bg])
            <div style="background: {{ $bg }}; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px;">
                <div style="font-size: 8px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 6px;">{{ $lbl }}</div>
                <div style="font-size: 28px; font-weight: 900; color: {{ $clr }}; line-height: 1;">{{ $val }}</div>
                <div style="font-size: 8px; color: #94a3b8; margin-top: 5px; font-weight: 600;">{{ $sub }}</div>
            </div>
            @endforeach
        </div>

        {{-- Two column detail grid --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">

            {{-- Population --}}
            <div style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div style="background: #1d4ed8; padding: 10px 16px;">
                    <span style="font-size: 9px; font-weight: 900; color: white; text-transform: uppercase; letter-spacing: 0.2em;">Population Overview</span>
                    <span style="float: right; font-size: 9px; color: rgba(255,255,255,0.6); font-weight: 700;">{{ $totalResidents }} total residents</span>
                </div>
                <div style="padding: 14px 16px;">
                    {{-- Gender --}}
                    <table style="width: 100%; margin-bottom: 12px;">
                        <tr>
                            <td style="font-size: 9px; font-weight: 800; color: #3b82f6; text-transform: uppercase;">Male</td>
                            <td style="font-size: 20px; font-weight: 900; color: #2563eb; text-align: center;">{{ $maleCount }}</td>
                            <td style="font-size: 9px; color: #94a3b8; text-align: center;">{{ $malePct }}%</td>
                            <td style="font-size: 20px; font-weight: 900; color: #ec4899; text-align: center;">{{ $femaleCount }}</td>
                            <td style="font-size: 9px; color: #94a3b8; text-align: center;">{{ $femalePct }}%</td>
                            <td style="font-size: 9px; font-weight: 800; color: #ec4899; text-transform: uppercase; text-align: right;">Female</td>
                        </tr>
                    </table>
                    <div style="height: 1px; background: #f1f5f9; margin-bottom: 10px;"></div>
                    {{-- Age Groups --}}
                    <div style="font-size: 8px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 8px;">Age Distribution</div>
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach($ageGroups as $label => $count)
                        @php $pct = $totalResidents > 0 ? round(($count / $totalResidents) * 100) : 0; @endphp
                        <tr>
                            <td style="font-size: 9px; color: #475569; font-weight: 600; padding: 3px 0; width: 110px;">{{ $label }}</td>
                            <td style="padding: 3px 8px;">
                                <div style="background: #f1f5f9; border-radius: 4px; height: 6px; width: 100%;">
                                    <div style="background: #1d4ed8; border-radius: 4px; height: 6px; width: {{ $pct }}%;"></div>
                                </div>
                            </td>
                            <td style="font-size: 9px; font-weight: 800; color: #334155; text-align: right; width: 24px;">{{ $count }}</td>
                            <td style="font-size: 9px; color: #94a3b8; text-align: right; width: 36px;">{{ $pct }}%</td>
                        </tr>
                        @endforeach
                    </table>
                    @if($newResidents > 0)
                    <div style="margin-top: 10px; padding-top: 8px; border-top: 1px solid #f1f5f9; font-size: 9px; color: #64748b;">
                        New registrations this month: <strong style="color: #1d4ed8;">{{ $newResidents }}</strong>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Document Requests --}}
            <div style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div style="background: #1e40af; padding: 10px 16px;">
                    <span style="font-size: 9px; font-weight: 900; color: white; text-transform: uppercase; letter-spacing: 0.2em;">Document Requests</span>
                    <span style="float: right; font-size: 9px; color: rgba(255,255,255,0.6); font-weight: 700;">{{ $totalDocs }} this month</span>
                </div>
                <div style="padding: 14px 16px;">
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
                        <tr>
                            @foreach([['Pending', $pendingDocs, '#d97706', '#fffbeb'], ['Approved', $approvedDocs, '#16a34a', '#f0fdf4'], ['Rejected', $rejectedDocs, '#dc2626', '#fef2f2']] as [$lbl, $val, $clr, $bg])
                            <td style="text-align: center; padding: 10px 6px;">
                                <div style="background: {{ $bg }}; border-radius: 8px; padding: 10px 8px;">
                                    <div style="font-size: 22px; font-weight: 900; color: {{ $clr }};">{{ $val }}</div>
                                    <div style="font-size: 8px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-top: 3px;">{{ $lbl }}</div>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                    </table>
                    @if($docsByType->isNotEmpty())
                    <div style="height: 1px; background: #f1f5f9; margin-bottom: 10px;"></div>
                    <div style="font-size: 8px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 8px;">By Document Type</div>
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach($docsByType as $doc)
                        @php $pct = $totalDocs > 0 ? round(($doc->total / $totalDocs) * 100) : 0; @endphp
                        <tr>
                            <td style="font-size: 9px; color: #475569; font-weight: 600; padding: 3px 0; width: 130px; text-transform: capitalize;">{{ str_replace('_', ' ', $doc->document_type) }}</td>
                            <td style="padding: 3px 8px;">
                                <div style="background: #f1f5f9; border-radius: 4px; height: 6px;">
                                    <div style="background: #3b82f6; border-radius: 4px; height: 6px; width: {{ $pct }}%;"></div>
                                </div>
                            </td>
                            <td style="font-size: 9px; font-weight: 800; color: #334155; text-align: right; width: 24px;">{{ $doc->total }}</td>
                            <td style="font-size: 9px; color: #94a3b8; text-align: right; width: 36px;">{{ $pct }}%</td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bottom row --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">

            {{-- Complaints --}}
            <div style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div style="background: #92400e; padding: 10px 16px;">
                    <span style="font-size: 9px; font-weight: 900; color: white; text-transform: uppercase; letter-spacing: 0.2em;">Complaints</span>
                    <span style="float: right; font-size: 9px; color: rgba(255,255,255,0.6); font-weight: 700;">{{ $totalComplaints }} this month</span>
                </div>
                <div style="padding: 14px 16px;">
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
                        <tr>
                            @foreach([['Open', $openComplaints, '#d97706', '#fffbeb'], ['Closed', $closedComplaints, '#16a34a', '#f0fdf4'], ['Critical', $criticalComplaints, '#dc2626', '#fef2f2']] as [$lbl, $val, $clr, $bg])
                            <td style="text-align: center; padding: 10px 6px;">
                                <div style="background: {{ $bg }}; border-radius: 8px; padding: 10px 8px;">
                                    <div style="font-size: 22px; font-weight: 900; color: {{ $clr }};">{{ $val }}</div>
                                    <div style="font-size: 8px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-top: 3px;">{{ $lbl }}</div>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                    </table>
                    @if($totalComplaints > 0)
                    <div style="height: 1px; background: #f1f5f9; margin-bottom: 10px;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                        <span style="font-size: 9px; color: #64748b; font-weight: 600;">Resolution Rate</span>
                        <span style="font-size: 11px; font-weight: 900; color: #16a34a;">{{ $resolvedPct }}%</span>
                    </div>
                    <div style="background: #f1f5f9; border-radius: 4px; height: 8px;">
                        <div style="background: #22c55e; border-radius: 4px; height: 8px; width: {{ $resolvedPct }}%;"></div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Feedback --}}
            <div style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div style="background: #166534; padding: 10px 16px;">
                    <span style="font-size: 9px; font-weight: 900; color: white; text-transform: uppercase; letter-spacing: 0.2em;">Resident Feedback</span>
                    <span style="float: right; font-size: 9px; color: rgba(255,255,255,0.6); font-weight: 700;">{{ $totalFeedback }} this month</span>
                </div>
                <div style="padding: 14px 16px;">
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
                        <tr>
                            @foreach([['Positive', $positiveFeedback, '#16a34a', '#f0fdf4'], ['Negative', $negativeFeedback, '#dc2626', '#fef2f2']] as [$lbl, $val, $clr, $bg])
                            <td style="text-align: center; padding: 10px 6px;">
                                <div style="background: {{ $bg }}; border-radius: 8px; padding: 10px 8px;">
                                    <div style="font-size: 22px; font-weight: 900; color: {{ $clr }};">{{ $val }}</div>
                                    <div style="font-size: 8px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-top: 3px;">{{ $lbl }}</div>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                    </table>
                    @if($totalFeedback > 0)
                    <div style="height: 1px; background: #f1f5f9; margin-bottom: 10px;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                        <span style="font-size: 9px; color: #64748b; font-weight: 600;">Satisfaction Rate</span>
                        <span style="font-size: 11px; font-weight: 900; color: #16a34a;">{{ $posPct }}%</span>
                    </div>
                    <div style="background: #f1f5f9; border-radius: 4px; height: 8px;">
                        <div style="background: #22c55e; border-radius: 4px; height: 8px; width: {{ $posPct }}%;"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div style="border-top: 2px solid #e2e8f0; padding-top: 12px; display: flex; justify-content: space-between; align-items: center;">
            <p style="font-size: 8px; color: #94a3b8; font-weight: 600;">Generated from the Barangay 419 Admin Portal</p>
            <p style="font-size: 8px; color: #94a3b8; font-weight: 600;">{{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
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
            ['label' => 'Total Residents',   'value' => $totalResidents,    'sub' => $newResidents . ' new this month', 'color' => 'text-gray-800',   'dot' => 'bg-gray-400'],
            ['label' => 'Document Requests', 'value' => $allTimeDocs,       'sub' => $pendingDocs . ' pending this month',   'color' => 'text-blue-700',   'dot' => 'bg-blue-400'],
            ['label' => 'Complaints',        'value' => $allTimeComplaints, 'sub' => $openComplaints . ' open this month',   'color' => 'text-amber-700',  'dot' => 'bg-amber-400'],
            ['label' => 'Feedback',          'value' => $allTimeFeedback,   'sub' => $positiveFeedback . ' positive this month', 'color' => 'text-green-700',  'dot' => 'bg-green-400'],
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
                {{-- Gender --}}
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
                {{-- Status row --}}
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

</div>

<style>
@media print {
    @page { size: A4 portrait; margin: 15mm 18mm; }

    body, html {
        background: white !important;
        overflow: visible !important;
        height: auto !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* Hide sidebar, topbar, and all screen-only UI */
    body > div > aside,
    body > div > div > header,
    body > div > div > main > div > div:not(.print-only),
    .no-print { display: none !important; }

    /* Show the print layout */
    body > div > div > main > div > .print-only { display: block !important; }

    /* Reset layout wrappers so content fills the page */
    body > div,
    body > div > div,
    body > div > div > main,
    body > div > div > main > div {
        display: block !important;
        width: 100% !important;
        height: auto !important;
        overflow: visible !important;
        padding: 0 !important;
        margin: 0 !important;
        max-width: 100% !important;
        background: white !important;
        box-shadow: none !important;
        border: none !important;
    }
}
</style>
@endsection
