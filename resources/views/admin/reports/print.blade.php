<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Barangay 419 — Monthly Report {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; background: white; }

@@page { size: A4 portrait; margin: 14mm 16mm; }
@@media print { .no-print { display: none !important; } }

/* ── Print button (screen only) ── */
.no-print {
    text-align: center;
    padding: 16px 0 24px;
}
.no-print button {
    background: #1d4ed8; color: white; border: none;
    padding: 10px 28px; font-size: 12px; font-weight: 700;
    border-radius: 8px; cursor: pointer; letter-spacing: 0.04em;
}
.no-print button:hover { background: #1e3a8a; }

/* ── Document wrapper ── */
.doc { padding: 0; }

/* ── Header ── */
.hdr-table { width: 100%; border-collapse: collapse; border-bottom: 3px solid #1d4ed8; padding-bottom: 12px; margin-bottom: 16px; }
.hdr-logo { width: 64px; vertical-align: middle; }
.hdr-logo img { width: 56px; height: 56px; object-fit: contain; display: block; }
.hdr-center { vertical-align: middle; text-align: center; padding: 0 12px; }
.hdr-center .gov { font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.12em; }
.hdr-center .brgy { font-size: 20px; font-weight: 900; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.06em; line-height: 1; margin: 4px 0 2px; }
.hdr-center .addr { font-size: 9px; color: #94a3b8; }
.hdr-center .period { font-size: 11px; font-weight: 800; color: #1d4ed8; margin-top: 5px; }
.hdr-right { width: 100px; vertical-align: middle; text-align: right; }
.hdr-right .gen-label { font-size: 8px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; }
.hdr-right .gen-date { font-size: 10px; font-weight: 800; color: #334155; }
.hdr-right .gen-time { font-size: 8.5px; color: #94a3b8; margin-top: 2px; }

/* ── Section heading ── */
.sec-head {
    font-size: 8px; font-weight: 900; color: white;
    text-transform: uppercase; letter-spacing: 0.2em;
    padding: 6px 10px;
    margin-bottom: 0;
}

/* ── Summary row ── */
.summary-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
.summary-table td { width: 25%; padding: 4px; vertical-align: top; }
.sum-card { border-radius: 8px; padding: 10px 12px; border: 1px solid #e2e8f0; }
.sum-card .lbl { font-size: 7.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 4px; }
.sum-card .val { font-size: 26px; font-weight: 900; line-height: 1; }
.sum-card .sub { font-size: 8px; color: #94a3b8; margin-top: 4px; font-weight: 600; }

/* ── Two-column layout ── */
.two-col { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
.two-col > tbody > tr > td { vertical-align: top; padding: 4px; }
.two-col > tbody > tr > td:first-child { width: 50%; }
.two-col > tbody > tr > td:last-child  { width: 50%; }

/* ── Card ── */
.card { border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
.card-body { padding: 11px 13px; }

/* ── Gender bar ── */
.gender-wrap { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; }
.gender-num { text-align: center; min-width: 42px; }
.gender-num .n { font-size: 20px; font-weight: 900; line-height: 1; }
.gender-num .l { font-size: 7.5px; font-weight: 800; text-transform: uppercase; color: #94a3b8; margin-top: 2px; }
.gender-bar-outer { flex: 1; background: #f1f5f9; border-radius: 4px; height: 6px; }
.gender-bar-inner { height: 6px; border-radius: 4px; }

/* ── Data table ── */
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead th {
    font-size: 7.5px; font-weight: 800; color: #94a3b8;
    text-transform: uppercase; letter-spacing: 0.1em;
    padding: 5px 8px; background: #f8fafc;
    border-bottom: 1px solid #e2e8f0; text-align: left;
}
.data-table thead th.right { text-align: right; }
.data-table tbody td { font-size: 10px; color: #475569; padding: 5px 8px; border-bottom: 1px solid #f1f5f9; }
.data-table tbody td.num { font-weight: 700; color: #1e293b; text-align: right; }
.data-table tbody td.pct { color: #94a3b8; text-align: right; }

/* ── Stat tiles ── */
.tiles-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
.tiles-table td { padding: 3px; }
.tile { border-radius: 7px; padding: 8px 5px; text-align: center; }
.tile .n { font-size: 20px; font-weight: 900; line-height: 1; }
.tile .l { font-size: 7.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-top: 2px; }

/* ── Rate bar ── */
.rate-row { display: flex; justify-content: space-between; align-items: center; margin-top: 9px; padding-top: 9px; border-top: 1px solid #f1f5f9; margin-bottom: 4px; }
.rate-lbl { font-size: 9px; color: #64748b; font-weight: 600; }
.rate-val { font-size: 12px; font-weight: 900; color: #16a34a; }
.bar-outer { background: #f1f5f9; border-radius: 4px; height: 6px; }
.bar-inner { border-radius: 4px; height: 6px; }

/* ── Note inline ── */
.note { font-size: 8.5px; color: #64748b; margin-top: 8px; padding-top: 8px; border-top: 1px solid #f1f5f9; }
.note strong { color: #1d4ed8; }

/* ── Footer ── */
.footer { border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 16px; }
.footer-table { width: 100%; border-collapse: collapse; }
.footer-table td { font-size: 8px; color: #94a3b8; vertical-align: top; }
.footer-table td:last-child { text-align: right; }

/* ── Section label ── */
.sec-lbl { font-size: 7.5px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 6px; margin-top: 2px; }
</style>
</head>
<body>

@php
    $reportMonth = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
    $malePct     = $totalResidents > 0 ? round(($maleCount        / $totalResidents) * 100) : 0;
    $femalePct   = 100 - $malePct;
    $resolvedPct = $totalComplaints > 0 ? round(($closedComplaints / $totalComplaints) * 100) : 0;
    $posPct      = $totalFeedback   > 0 ? round(($positiveFeedback / $totalFeedback)   * 100) : 0;
@endphp

<div class="no-print">
    <button onclick="window.print()">&#128438;&nbsp; Print / Save as PDF</button>
</div>

<div class="doc">

{{-- ══ HEADER ══ --}}
<table class="hdr-table" style="border-bottom:3px solid #1d4ed8; padding-bottom:12px; margin-bottom:16px; width:100%; border-collapse:collapse;">
    <tbody><tr>
        <td class="hdr-logo">
            <img src="{{ asset('images/brgy_logo.png') }}" alt="Logo"
                 onerror="this.style.display='none'">
        </td>
        <td class="hdr-center">
            <div class="gov">Republic of the Philippines &bull; National Capital Region &bull; City of Manila</div>
            <div class="brgy">Barangay 419, Zone 43</div>
            <div class="addr">Sampaloc, Manila 1008 &bull; District IV</div>
            <div class="period">Monthly Barangay Report &mdash; {{ $reportMonth }}</div>
        </td>
        <td class="hdr-right">
            <div class="gen-label">Generated</div>
            <div class="gen-date">{{ now()->format('F d, Y') }}</div>
            <div class="gen-time">{{ now()->format('h:i A') }}</div>
        </td>
    </tr></tbody>
</table>

{{-- ══ SUMMARY AT A GLANCE ══ --}}
<table class="summary-table">
    <tbody><tr>
        <td style="padding:0 4px 0 0;">
            <div class="sum-card" style="background:#eff6ff; border-color:#bfdbfe;">
                <div class="lbl">Total Residents</div>
                <div class="val" style="color:#1e3a8a;">{{ $totalResidents }}</div>
                <div class="sub">{{ $newResidents }} new this month</div>
            </div>
        </td>
        <td style="padding:0 4px;">
            <div class="sum-card" style="background:#eff6ff; border-color:#bfdbfe;">
                <div class="lbl">Document Requests</div>
                <div class="val" style="color:#1d4ed8;">{{ $totalDocs }}</div>
                <div class="sub">{{ $pendingDocs }} pending</div>
            </div>
        </td>
        <td style="padding:0 4px;">
            <div class="sum-card" style="background:#fffbeb; border-color:#fde68a;">
                <div class="lbl">Complaints</div>
                <div class="val" style="color:#92400e;">{{ $totalComplaints }}</div>
                <div class="sub">{{ $openComplaints }} still open</div>
            </div>
        </td>
        <td style="padding:0 0 0 4px;">
            <div class="sum-card" style="background:#f0fdf4; border-color:#bbf7d0;">
                <div class="lbl">Feedback</div>
                <div class="val" style="color:#166534;">{{ $totalFeedback }}</div>
                <div class="sub">{{ $positiveFeedback }} positive</div>
            </div>
        </td>
    </tr></tbody>
</table>

{{-- ══ TOP ROW: Population | Document Requests ══ --}}
<table class="two-col">
    <tbody><tr>

        {{-- Population --}}
        <td style="padding-right:6px;">
            <div class="card">
                <div class="sec-head" style="background:#1d4ed8;">
                    Population Overview
                    <span style="float:right;font-weight:600;opacity:0.65;">{{ $totalResidents }} residents</span>
                </div>
                <div class="card-body">
                    {{-- Gender --}}
                    <div class="gender-wrap">
                        <div class="gender-num">
                            <div class="n" style="color:#2563eb;">{{ $maleCount }}</div>
                            <div class="l">Male</div>
                        </div>
                        <div class="gender-bar-outer">
                            <div class="gender-bar-inner" style="background:#60a5fa;width:{{ $malePct }}%;"></div>
                        </div>
                        <div class="gender-num">
                            <div class="n" style="color:#ec4899;">{{ $femaleCount }}</div>
                            <div class="l">Female</div>
                        </div>
                    </div>

                    {{-- Age groups --}}
                    <div class="sec-lbl">Age Distribution</div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Age Group</th>
                                <th class="right">Count</th>
                                <th class="right">Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ageGroups as $label => $count)
                            @php $pct = $totalResidents > 0 ? round(($count / $totalResidents) * 100) : 0; @endphp
                            <tr>
                                <td>{{ $label }}</td>
                                <td class="num">{{ $count }}</td>
                                <td class="pct">{{ $pct }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($newResidents > 0)
                    <p class="note">New registrations this month: <strong>{{ $newResidents }}</strong></p>
                    @endif
                </div>
            </div>
        </td>

        {{-- Document Requests --}}
        <td style="padding-left:6px;">
            <div class="card">
                <div class="sec-head" style="background:#1e40af;">
                    Document Requests
                    <span style="float:right;font-weight:600;opacity:0.65;">{{ $totalDocs }} this month</span>
                </div>
                <div class="card-body">
                    {{-- Status tiles --}}
                    <table class="tiles-table">
                        <tbody><tr>
                            <td><div class="tile" style="background:#fffbeb;"><div class="n" style="color:#d97706;">{{ $pendingDocs }}</div><div class="l">Pending</div></div></td>
                            <td><div class="tile" style="background:#eff6ff;"><div class="n" style="color:#2563eb;">{{ $processingDocs }}</div><div class="l">Processing</div></div></td>
                            <td><div class="tile" style="background:#eef2ff;"><div class="n" style="color:#4338ca;">{{ $readyDocs }}</div><div class="l">Ready</div></div></td>
                            <td><div class="tile" style="background:#f0fdf4;"><div class="n" style="color:#16a34a;">{{ $completedDocs }}</div><div class="l">Completed</div></div></td>
                            <td><div class="tile" style="background:#fef2f2;"><div class="n" style="color:#dc2626;">{{ $cancelledDocs }}</div><div class="l">Cancelled</div></div></td>
                        </tr></tbody>
                    </table>

                    @if($docsByType->isNotEmpty())
                    <div class="sec-lbl">By Document Type</div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Document Type</th>
                                <th class="right">Count</th>
                                <th class="right">Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docsByType as $doc)
                            @php $pct = $totalDocs > 0 ? round(($doc->total / $totalDocs) * 100) : 0; @endphp
                            <tr>
                                <td style="text-transform:capitalize;">{{ str_replace('_', ' ', $doc->document_type) }}</td>
                                <td class="num">{{ $doc->total }}</td>
                                <td class="pct">{{ $pct }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p style="font-size:9px;color:#94a3b8;text-align:center;padding:12px 0;">No document requests this month.</p>
                    @endif
                </div>
            </div>
        </td>

    </tr></tbody>
</table>

{{-- ══ BOTTOM ROW: Complaints | Feedback ══ --}}
<table class="two-col">
    <tbody><tr>

        {{-- Complaints --}}
        <td style="padding-right:6px;">
            <div class="card">
                <div class="sec-head" style="background:#b45309;">
                    Complaints
                    <span style="float:right;font-weight:600;opacity:0.65;">{{ $totalComplaints }} this month</span>
                </div>
                <div class="card-body">
                    <table class="tiles-table">
                        <tbody><tr>
                            <td><div class="tile" style="background:#fffbeb;"><div class="n" style="color:#d97706;">{{ $openComplaints }}</div><div class="l">Open</div></div></td>
                            <td><div class="tile" style="background:#f0fdf4;"><div class="n" style="color:#16a34a;">{{ $closedComplaints }}</div><div class="l">Closed</div></div></td>
                            <td><div class="tile" style="background:#fef2f2;"><div class="n" style="color:#dc2626;">{{ $criticalComplaints }}</div><div class="l">Critical</div></div></td>
                        </tr></tbody>
                    </table>
                    @if($totalComplaints > 0)
                    <div class="rate-row">
                        <span class="rate-lbl">Resolution Rate</span>
                        <span class="rate-val">{{ $resolvedPct }}%</span>
                    </div>
                    <div class="bar-outer">
                        <div class="bar-inner" style="background:#22c55e;width:{{ $resolvedPct }}%;"></div>
                    </div>
                    @else
                    <p style="font-size:9px;color:#94a3b8;text-align:center;padding:8px 0;">No complaints this month.</p>
                    @endif
                </div>
            </div>
        </td>

        {{-- Feedback --}}
        <td style="padding-left:6px;">
            <div class="card">
                <div class="sec-head" style="background:#166534;">
                    Resident Feedback
                    <span style="float:right;font-weight:600;opacity:0.65;">{{ $totalFeedback }} this month</span>
                </div>
                <div class="card-body">
                    <table class="tiles-table">
                        <tbody><tr>
                            <td><div class="tile" style="background:#f0fdf4;"><div class="n" style="color:#16a34a;">{{ $positiveFeedback }}</div><div class="l">Positive</div></div></td>
                            <td><div class="tile" style="background:#fef2f2;"><div class="n" style="color:#dc2626;">{{ $negativeFeedback }}</div><div class="l">Negative</div></div></td>
                        </tr></tbody>
                    </table>
                    @if($totalFeedback > 0)
                    <div class="rate-row">
                        <span class="rate-lbl">Satisfaction Rate</span>
                        <span class="rate-val">{{ $posPct }}%</span>
                    </div>
                    <div class="bar-outer">
                        <div class="bar-inner" style="background:#22c55e;width:{{ $posPct }}%;"></div>
                    </div>
                    @else
                    <p style="font-size:9px;color:#94a3b8;text-align:center;padding:8px 0;">No feedback this month.</p>
                    @endif
                </div>
            </div>
        </td>

    </tr></tbody>
</table>

{{-- ══ FOOTER ══ --}}
<div class="footer">
    <table class="footer-table">
        <tbody><tr>
            <td>Barangay 419 Official Monthly Report &bull; Generated from the Admin Portal</td>
            <td>{{ now()->format('F d, Y \a\t h:i A') }}</td>
        </tr></tbody>
    </table>
</div>

</div>{{-- end .doc --}}

<script>
window.addEventListener('load', function() { window.print(); });
</script>
</body>
</html>
