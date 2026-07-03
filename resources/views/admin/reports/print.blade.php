<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Barangay 419 — Monthly Report {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 11pt;
    color: #111;
    background: #f0f0f0;
    padding: 24px 0 48px;
}

@@page {
    size: A4 portrait;
    margin: 15mm 18mm 18mm 18mm;
}

@@media print {
    body { background: white !important; padding: 0 !important; }
    .no-print { display: none !important; }
    .page { box-shadow: none !important; margin: 0 !important; border: none !important; }
}

/* ── Screen wrapper ── */
.no-print {
    text-align: center;
    padding: 20px 0 28px;
    font-family: Arial, sans-serif;
}
.no-print button {
    background: #1d4ed8; color: white; border: none;
    padding: 12px 32px; font-size: 13px; font-weight: 700;
    border-radius: 8px; cursor: pointer; letter-spacing: 0.03em;
    box-shadow: 0 4px 12px rgba(29,78,216,0.3);
}
.no-print button:hover { background: #1e3a8a; }
.no-print .hint { font-family: Arial; font-size: 11px; color: #888; margin-top: 8px; }

/* ── Page ── */
.page {
    width: 210mm;
    min-height: 297mm;
    background: white;
    margin: 0 auto;
    padding: 18mm 20mm 18mm 20mm;
    box-shadow: 0 4px 32px rgba(0,0,0,0.15);
    border: 1px solid #ddd;
    position: relative;
}

/* ── Republic header ── */
.republic-line {
    text-align: center;
    font-size: 9pt;
    font-weight: bold;
    letter-spacing: 0.08em;
    color: #333;
    text-transform: uppercase;
    margin-bottom: 2pt;
}

/* ── Letterhead ── */
.letterhead {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding-bottom: 12pt;
    border-bottom: 4px double #1d4ed8;
    margin-bottom: 14pt;
}
.lh-logo {
    width: 68px; height: 68px;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.lh-logo img { width: 68px; height: 68px; object-fit: contain; }
.lh-logo .placeholder {
    width: 68px; height: 68px; border-radius: 50%;
    border: 2px solid #cbd5e1;
    display: flex; align-items: center; justify-content: center;
    color: #cbd5e1; font-size: 9pt;
}
.lh-center { flex: 1; text-align: center; }
.lh-center .ncr   { font-size: 8pt; color: #555; letter-spacing: 0.08em; text-transform: uppercase; }
.lh-center .bname { font-size: 18pt; font-weight: 900; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.05em; line-height: 1.1; margin: 4pt 0 3pt; }
.lh-center .bloc  { font-size: 9pt; color: #555; }
.lh-right { text-align: right; flex-shrink: 0; font-size: 8.5pt; color: #555; line-height: 1.7; min-width: 90px; }
.lh-right strong  { color: #222; font-size: 9pt; }

/* ── Report title bar ── */
.report-titlebar {
    text-align: center;
    margin-bottom: 14pt;
}
.report-titlebar .rtitle {
    font-size: 13pt; font-weight: bold; color: #1e3a8a;
    text-transform: uppercase; letter-spacing: 0.1em;
    border-top: 1px solid #1d4ed8;
    border-bottom: 1px solid #1d4ed8;
    padding: 5pt 0;
    margin: 0 40pt;
}
.report-titlebar .rperiod {
    font-size: 9.5pt; color: #444; margin-top: 4pt;
}

/* ── Section heading ── */
.sec-title {
    font-size: 8.5pt; font-weight: bold; font-family: Arial, sans-serif;
    text-transform: uppercase; letter-spacing: 0.18em;
    color: white; background: #1e3a8a;
    padding: 4pt 8pt;
    border-radius: 2px;
}

/* ── Summary row ── */
.summary-grid {
    width: 100%; border-collapse: collapse;
    margin-bottom: 14pt;
}
.summary-grid td { width: 25%; padding: 3pt; vertical-align: top; }
.scard {
    border: 1.5px solid #e2e8f0;
    border-radius: 5px;
    padding: 9pt 10pt;
}
.scard .slbl {
    font-size: 7pt; font-weight: bold; font-family: Arial, sans-serif;
    text-transform: uppercase; letter-spacing: 0.15em;
    color: #888; margin-bottom: 4pt;
}
.scard .sval { font-size: 24pt; font-weight: 900; line-height: 1; }
.scard .ssub { font-size: 7.5pt; color: #888; margin-top: 3pt; }

/* ── Two-column section ── */
.two-col { width: 100%; border-collapse: collapse; margin-bottom: 12pt; }
.two-col td { width: 50%; vertical-align: top; }
.two-col td:first-child { padding-right: 6pt; }
.two-col td:last-child  { padding-left:  6pt; }

/* ── Card ── */
.card { border: 1px solid #d1d5db; border-radius: 5px; overflow: hidden; margin-bottom: 0; }
.card-body { padding: 9pt 10pt; }

/* ── Gender display ── */
.gender-row { display: flex; align-items: center; gap: 10pt; margin-bottom: 8pt; padding-bottom: 8pt; border-bottom: 1px solid #f1f5f9; }
.gbox { text-align: center; min-width: 36pt; }
.gbox .gn { font-size: 18pt; font-weight: 900; line-height: 1; }
.gbox .gl { font-size: 6.5pt; font-weight: bold; font-family: Arial; text-transform: uppercase; color: #888; margin-top: 1pt; }
.gbar-out { flex: 1; background: #e9ecef; border-radius: 3px; height: 7px; overflow: hidden; }
.gbar-in  { height: 7px; border-radius: 3px; }

/* ── Data table ── */
.dtable { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; }
.dtable thead th {
    font-size: 7pt; font-weight: bold; color: #888;
    text-transform: uppercase; letter-spacing: 0.1em;
    padding: 4pt 6pt; background: #f8fafc;
    border-bottom: 1.5px solid #e2e8f0;
    text-align: left;
}
.dtable thead th.r { text-align: right; }
.dtable tbody td { font-size: 9pt; color: #333; padding: 4pt 6pt; border-bottom: 1px solid #f1f5f9; }
.dtable tbody td.num { font-weight: 700; text-align: right; color: #111; }
.dtable tbody td.pct { text-align: right; color: #94a3b8; }

/* ── Status tiles ── */
.tiles { width: 100%; border-collapse: collapse; margin-bottom: 9pt; }
.tiles td { padding: 2pt; }
.tile { border-radius: 4px; padding: 6pt 3pt; text-align: center; }
.tile .tn { font-size: 17pt; font-weight: 900; font-family: Arial; line-height: 1; }
.tile .tl { font-size: 6.5pt; font-weight: bold; font-family: Arial; text-transform: uppercase; color: #666; margin-top: 2pt; letter-spacing: 0.05em; }

/* ── Rate bar ── */
.rate-head { display: flex; justify-content: space-between; align-items: center; margin-top: 8pt; padding-top: 8pt; border-top: 1px solid #f1f5f9; margin-bottom: 3pt; }
.rate-lbl { font-size: 8.5pt; color: #555; font-family: Arial; }
.rate-val { font-size: 11pt; font-weight: 900; font-family: Arial; color: #16a34a; }
.bar-out { background: #e9ecef; border-radius: 3px; height: 6px; overflow: hidden; }
.bar-in  { height: 6px; border-radius: 3px; }

/* ── Sub-label ── */
.sub-lbl { font-size: 7pt; font-weight: bold; font-family: Arial; text-transform: uppercase; letter-spacing: 0.14em; color: #888; margin-bottom: 5pt; }

/* ── Inline note ── */
.note { font-size: 8pt; font-family: Arial; color: #555; margin-top: 7pt; padding-top: 7pt; border-top: 1px solid #f1f5f9; }
.note strong { color: #1d4ed8; }

/* ── Signature block ── */
.sig-block { margin-top: 20pt; }
.sig-table { width: 100%; border-collapse: collapse; }
.sig-table td { width: 33%; padding: 0 8pt; vertical-align: bottom; }
.sig-table td:first-child { padding-left: 0; }
.sig-table td:last-child  { padding-right: 0; }
.sig-line { border-top: 1.5px solid #333; padding-top: 4pt; margin-top: 28pt; }
.sig-name { font-size: 10pt; font-weight: bold; text-align: center; }
.sig-title { font-size: 8pt; font-family: Arial; text-align: center; color: #555; }

/* ── Footer ── */
.doc-footer {
    border-top: 1.5px solid #d1d5db;
    margin-top: 16pt; padding-top: 7pt;
    display: flex; justify-content: space-between;
    font-family: Arial; font-size: 7.5pt; color: #888;
}
.doc-footer .fl { }
.doc-footer .fr { text-align: right; }

/* ── Watermark period ── */
.period-badge {
    display: inline-block;
    border: 1.5px solid #1d4ed8;
    border-radius: 3px;
    padding: 2pt 10pt;
    font-size: 9pt; font-weight: bold; font-family: Arial;
    color: #1d4ed8; letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 12pt;
}
</style>
</head>
<body>

@php
    $reportMonth = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
    $malePct     = $totalResidents > 0 ? round(($maleCount        / $totalResidents) * 100) : 0;
    $resolvedPct = $totalComplaints > 0 ? round(($closedComplaints / $totalComplaints) * 100) : 0;
    $posPct      = $totalFeedback   > 0 ? round(($positiveFeedback / $totalFeedback)   * 100) : 0;
@endphp

<div class="no-print">
    <button onclick="window.print()">&#128438;&nbsp; Print / Save as PDF</button>
    <p class="hint">Opens your printer dialog — choose "Save as PDF" to keep a digital copy.</p>
</div>

<div class="page">

    {{-- ══ REPUBLIC HEADER ══ --}}
    <p class="republic-line">Republic of the Philippines</p>

    {{-- ══ LETTERHEAD ══ --}}
    <div class="letterhead">
        <div class="lh-logo">
            <img src="{{ asset('images/manila-seal.png') }}" alt="Manila"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="placeholder" style="display:none;">Manila</div>
        </div>

        <div class="lh-center">
            <div class="ncr">National Capital Region &bull; City of Manila &bull; District IV</div>
            <div class="bname">Barangay 419, Zone 43</div>
            <div class="bloc">Sampaloc, Manila 1008</div>
        </div>

        <div class="lh-logo" style="justify-content:flex-end;">
            <img src="{{ asset('images/barangay-seal.png') }}" alt="Barangay"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="placeholder" style="display:none;">Brgy</div>
        </div>
    </div>

    {{-- ══ REPORT TITLE ══ --}}
    <div class="report-titlebar">
        <div class="rtitle">Monthly Barangay Statistical Report</div>
        <div class="rperiod">For the Month of &nbsp;<strong>{{ $reportMonth }}</strong></div>
    </div>

    <div style="text-align:right; margin-bottom:12pt;">
        <span class="period-badge">Reporting Period: {{ $reportMonth }}</span>
    </div>

    {{-- ══ SUMMARY AT A GLANCE ══ --}}
    <div style="margin-bottom:5pt;">
        <span class="sec-title">I. &nbsp; Summary at a Glance</span>
    </div>
    <table class="summary-grid">
        <tbody><tr>
            <td style="padding:3pt 3pt 3pt 0;">
                <div class="scard" style="background:#eff6ff; border-color:#bfdbfe;">
                    <div class="slbl">Total Residents</div>
                    <div class="sval" style="color:#1e3a8a;">{{ $totalResidents }}</div>
                    <div class="ssub">{{ $newResidents }} registered this month</div>
                </div>
            </td>
            <td style="padding:3pt;">
                <div class="scard" style="background:#eff6ff; border-color:#bfdbfe;">
                    <div class="slbl">Document Requests</div>
                    <div class="sval" style="color:#1d4ed8;">{{ $totalDocs }}</div>
                    <div class="ssub">{{ $pendingDocs }} pending action</div>
                </div>
            </td>
            <td style="padding:3pt;">
                <div class="scard" style="background:#fffbeb; border-color:#fde68a;">
                    <div class="slbl">Complaints Filed</div>
                    <div class="sval" style="color:#92400e;">{{ $totalComplaints }}</div>
                    <div class="ssub">{{ $openComplaints }} remain open</div>
                </div>
            </td>
            <td style="padding:3pt 0 3pt 3pt;">
                <div class="scard" style="background:#f0fdf4; border-color:#bbf7d0;">
                    <div class="slbl">Resident Feedback</div>
                    <div class="sval" style="color:#166534;">{{ $totalFeedback }}</div>
                    <div class="ssub">{{ $positiveFeedback }} positive responses</div>
                </div>
            </td>
        </tr></tbody>
    </table>

    {{-- ══ POPULATION & DOCUMENTS ══ --}}
    <div style="margin-bottom:5pt;">
        <span class="sec-title">II. &nbsp; Population &amp; Document Requests</span>
    </div>
    <table class="two-col" style="margin-bottom:12pt;">
        <tbody><tr>

            {{-- Population --}}
            <td>
                <div class="card">
                    <div style="background:#1d4ed8; padding:5pt 10pt; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:8pt;font-weight:bold;font-family:Arial;color:white;text-transform:uppercase;letter-spacing:0.14em;">Population Overview</span>
                        <span style="font-size:7.5pt;color:rgba(255,255,255,0.65);font-family:Arial;">{{ $totalResidents }} total</span>
                    </div>
                    <div class="card-body">
                        <div class="gender-row">
                            <div class="gbox">
                                <div class="gn" style="color:#1d4ed8;">{{ $maleCount }}</div>
                                <div class="gl">Male</div>
                            </div>
                            <div class="gbar-out">
                                <div class="gbar-in" style="background:#60a5fa;width:{{ $malePct }}%;"></div>
                            </div>
                            <div class="gbox">
                                <div class="gn" style="color:#db2777;">{{ $femaleCount }}</div>
                                <div class="gl">Female</div>
                            </div>
                        </div>

                        <div class="sub-lbl">Age Group Distribution</div>
                        <table class="dtable">
                            <thead><tr>
                                <th>Age Group</th>
                                <th class="r">Count</th>
                                <th class="r">Share</th>
                            </tr></thead>
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
            <td>
                <div class="card">
                    <div style="background:#1e40af; padding:5pt 10pt; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:8pt;font-weight:bold;font-family:Arial;color:white;text-transform:uppercase;letter-spacing:0.14em;">Document Requests</span>
                        <span style="font-size:7.5pt;color:rgba(255,255,255,0.65);font-family:Arial;">{{ $totalDocs }} this month</span>
                    </div>
                    <div class="card-body">
                        <table class="tiles">
                            <tbody><tr>
                                <td><div class="tile" style="background:#fffbeb;"><div class="tn" style="color:#d97706;">{{ $pendingDocs }}</div><div class="tl">Pending</div></div></td>
                                <td><div class="tile" style="background:#eff6ff;"><div class="tn" style="color:#2563eb;">{{ $processingDocs }}</div><div class="tl">Processing</div></div></td>
                                <td><div class="tile" style="background:#eef2ff;"><div class="tn" style="color:#4338ca;">{{ $readyDocs }}</div><div class="tl">Ready</div></div></td>
                                <td><div class="tile" style="background:#f0fdf4;"><div class="tn" style="color:#16a34a;">{{ $completedDocs }}</div><div class="tl">Completed</div></div></td>
                                <td><div class="tile" style="background:#fef2f2;"><div class="tn" style="color:#dc2626;">{{ $cancelledDocs }}</div><div class="tl">Cancelled</div></div></td>
                            </tr></tbody>
                        </table>

                        @if($docsByType->isNotEmpty())
                        <div class="sub-lbl">Breakdown by Document Type</div>
                        <table class="dtable">
                            <thead><tr>
                                <th>Document Type</th>
                                <th class="r">Count</th>
                                <th class="r">Share</th>
                            </tr></thead>
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
                        <p style="font-size:8.5pt;font-family:Arial;color:#94a3b8;text-align:center;padding:10pt 0;">No document requests recorded this month.</p>
                        @endif
                    </div>
                </div>
            </td>

        </tr></tbody>
    </table>

    {{-- ══ COMPLAINTS & FEEDBACK ══ --}}
    <div style="margin-bottom:5pt;">
        <span class="sec-title">III. &nbsp; Complaints &amp; Resident Feedback</span>
    </div>
    <table class="two-col" style="margin-bottom:16pt;">
        <tbody><tr>

            {{-- Complaints --}}
            <td>
                <div class="card">
                    <div style="background:#92400e; padding:5pt 10pt; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:8pt;font-weight:bold;font-family:Arial;color:white;text-transform:uppercase;letter-spacing:0.14em;">Complaints</span>
                        <span style="font-size:7.5pt;color:rgba(255,255,255,0.65);font-family:Arial;">{{ $totalComplaints }} this month</span>
                    </div>
                    <div class="card-body">
                        <table class="tiles">
                            <tbody><tr>
                                <td><div class="tile" style="background:#fffbeb;"><div class="tn" style="color:#d97706;">{{ $openComplaints }}</div><div class="tl">Open</div></div></td>
                                <td><div class="tile" style="background:#f0fdf4;"><div class="tn" style="color:#16a34a;">{{ $closedComplaints }}</div><div class="tl">Closed</div></div></td>
                                <td><div class="tile" style="background:#fef2f2;"><div class="tn" style="color:#dc2626;">{{ $criticalComplaints }}</div><div class="tl">Critical</div></div></td>
                            </tr></tbody>
                        </table>
                        @if($totalComplaints > 0)
                        <div class="rate-head">
                            <span class="rate-lbl">Resolution Rate</span>
                            <span class="rate-val">{{ $resolvedPct }}%</span>
                        </div>
                        <div class="bar-out"><div class="bar-in" style="background:#22c55e;width:{{ $resolvedPct }}%;"></div></div>
                        @else
                        <p style="font-size:8.5pt;font-family:Arial;color:#94a3b8;text-align:center;padding:8pt 0;">No complaints recorded this month.</p>
                        @endif
                    </div>
                </div>
            </td>

            {{-- Feedback --}}
            <td>
                <div class="card">
                    <div style="background:#166534; padding:5pt 10pt; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:8pt;font-weight:bold;font-family:Arial;color:white;text-transform:uppercase;letter-spacing:0.14em;">Resident Feedback</span>
                        <span style="font-size:7.5pt;color:rgba(255,255,255,0.65);font-family:Arial;">{{ $totalFeedback }} this month</span>
                    </div>
                    <div class="card-body">
                        <table class="tiles">
                            <tbody><tr>
                                <td><div class="tile" style="background:#f0fdf4;"><div class="tn" style="color:#16a34a;">{{ $positiveFeedback }}</div><div class="tl">Positive</div></div></td>
                                <td><div class="tile" style="background:#fef2f2;"><div class="tn" style="color:#dc2626;">{{ $negativeFeedback }}</div><div class="tl">Negative</div></div></td>
                            </tr></tbody>
                        </table>
                        @if($totalFeedback > 0)
                        <div class="rate-head">
                            <span class="rate-lbl">Satisfaction Rate</span>
                            <span class="rate-val">{{ $posPct }}%</span>
                        </div>
                        <div class="bar-out"><div class="bar-in" style="background:#22c55e;width:{{ $posPct }}%;"></div></div>
                        @else
                        <p style="font-size:8.5pt;font-family:Arial;color:#94a3b8;text-align:center;padding:8pt 0;">No feedback recorded this month.</p>
                        @endif
                    </div>
                </div>
            </td>

        </tr></tbody>
    </table>

    {{-- ══ CERTIFYING SIGNATURE ══ --}}
    <div class="sig-block">
        <div class="sig-table" style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="width:40%;padding-right:12pt;vertical-align:bottom;">
                    <div style="margin-top:28pt;border-top:1.5px solid #333;padding-top:4pt;">
                        <div style="font-size:10pt;font-weight:bold;text-align:center;">ERWIN R. MOLINA</div>
                        <div style="font-size:8.5pt;font-family:Arial;text-align:center;color:#444;">Punong Barangay</div>
                        <div style="font-size:8pt;font-family:Arial;text-align:center;color:#888;margin-top:1pt;">Barangay 419, Zone 43, Sampaloc, Manila</div>
                    </div>
                </td>
                <td style="width:20%;"></td>
                <td style="width:40%;padding-left:12pt;vertical-align:bottom;text-align:right;">
                    <div style="font-size:8pt;font-family:Arial;color:#555;line-height:1.8;">
                        <div>Date prepared: <span style="border-bottom:1px solid #888;display:inline-block;min-width:80pt;">&nbsp;</span></div>
                        <div>OR No.: <span style="border-bottom:1px solid #888;display:inline-block;min-width:90pt;">&nbsp;</span></div>
                        <div>Control No.: <span style="border-bottom:1px solid #888;display:inline-block;min-width:80pt;">&nbsp;</span></div>
                    </div>
                </td>
            </tr>
        </div>
    </div>

    {{-- ══ DOCUMENT FOOTER ══ --}}
    <div class="doc-footer">
        <div class="fl">
            Generated from Barangay 419 Admin Portal &bull; {{ now()->format('F d, Y \a\t h:i A') }}
        </div>
        <div class="fr">
            This report is computer-generated and valid without signature unless certified.
        </div>
    </div>

</div>{{-- end .page --}}

<script>
window.addEventListener('load', function () { window.print(); });
</script>
</body>
</html>
