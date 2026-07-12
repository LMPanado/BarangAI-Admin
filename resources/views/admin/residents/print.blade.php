<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Residents — Barangay 419</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background: #fff;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 18mm 18mm 20mm 18mm;
            background: #fff;
        }

        /* ── Letterhead ── */
        .letterhead {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-bottom: 6px;
        }
        .letterhead img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        .letterhead-center {
            text-align: center;
        }
        .lh-republic {
            font-size: 9pt;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .lh-barangay {
            font-size: 20pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            line-height: 1;
        }
        .lh-city {
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 2px;
        }
        .lh-office {
            font-size: 8.5pt;
            font-style: italic;
            color: #444;
            margin-top: 1px;
        }

        /* ── Dividers ── */
        .rule-thick {
            border: none;
            border-top: 3px solid #000;
            margin: 6px 0 2px;
        }
        .rule-thin {
            border: none;
            border-top: 1px solid #000;
            margin: 0 0 10px;
        }

        /* ── Document Title ── */
        .doc-title {
            text-align: center;
            margin: 12px 0 4px;
        }
        .doc-title h2 {
            font-size: 14pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            text-decoration: underline;
        }
        .doc-title p {
            font-size: 9pt;
            font-style: italic;
            color: #333;
            margin-top: 2px;
        }

        /* ── Meta info row ── */
        .meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
            margin: 10px 0 10px;
            border: 1px solid #000;
            padding: 6px 10px;
            background: #f9f9f9;
        }
        .meta-row span { display: inline-block; }
        .meta-label { font-weight: 700; }

        /* ── Stats row ── */
        .stats-row {
            display: flex;
            gap: 0;
            margin-bottom: 10px;
            border: 1px solid #000;
            border-radius: 0;
            overflow: hidden;
        }
        .stats-row .stat {
            flex: 1;
            text-align: center;
            padding: 6px 4px;
            border-right: 1px solid #000;
        }
        .stats-row .stat:last-child { border-right: none; }
        .stat .sv { font-size: 15pt; font-weight: 700; }
        .stat .sl { font-size: 7.5pt; text-transform: uppercase; letter-spacing: 0.06em; }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-bottom: 14px;
        }
        thead tr {
            background: #000;
            color: #fff;
        }
        thead th {
            padding: 5px 6px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-size: 7.5pt;
            white-space: nowrap;
        }
        thead th.center { text-align: center; }
        tbody tr:nth-child(even) { background: #f5f5f5; }
        tbody td {
            padding: 4px 6px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            vertical-align: top;
        }
        tbody td:last-child { border-right: none; }
        tbody td.center { text-align: center; }
        .row-num { color: #666; font-size: 7.5pt; text-align: center; }
        .res-name { font-weight: 700; font-family: Arial, sans-serif; font-size: 8.5pt; }
        .res-email { font-size: 7pt; color: #555; font-style: italic; }

        /* ── Certification block ── */
        .certification {
            font-size: 9.5pt;
            margin-top: 10px;
            line-height: 1.7;
            text-align: justify;
        }
        .certification .blank {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 120px;
            text-align: center;
            font-weight: 700;
            vertical-align: bottom;
        }

        /* ── Signature ── */
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .sig-left {
            font-size: 8.5pt;
            color: #333;
        }
        .sig-left p { margin-bottom: 3px; }
        .sig-block {
            text-align: center;
        }
        .sig-block .sig-name {
            font-size: 11pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-top: 1px solid #000;
            padding-top: 4px;
            margin-top: 40px;
            min-width: 220px;
        }
        .sig-block .sig-title {
            font-size: 8.5pt;
            font-style: italic;
        }
        .sig-block .sig-label {
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #444;
            margin-top: 2px;
        }

        /* ── Footer ── */
        .doc-footer {
            margin-top: 20px;
            padding-top: 6px;
            border-top: 1px solid #000;
            display: flex;
            justify-content: space-between;
            font-size: 7.5pt;
            color: #555;
            font-style: italic;
        }

        /* ── Print controls (screen only) ── */
        .print-controls {
            width: 210mm;
            margin: 16px auto 0;
            display: flex;
            gap: 10px;
            font-family: Arial, sans-serif;
        }
        .btn-print {
            background: #166534;
            color: #fff;
            border: none;
            padding: 10px 28px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-close {
            background: #e2e8f0;
            color: #475569;
            border: none;
            padding: 10px 22px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-radius: 6px;
            cursor: pointer;
        }

        @media print {
            body { background: #fff; }
            .print-controls { display: none !important; }
            .page { padding: 14mm 16mm; margin: 0; width: 100%; }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>
</head>
<body>

<div class="print-controls">
    <button class="btn-print" onclick="window.print()">&#128438; Print Document</button>
    <button class="btn-close" onclick="window.close()">Close</button>
</div>

<div class="page">

    {{-- ── Letterhead ── --}}
    <div class="letterhead">
        <img src="{{ asset('images/brgy_logo.png') }}" alt="Barangay 419 Seal">
        <div class="letterhead-center">
            <div class="lh-republic">Republic of the Philippines</div>
            <div class="lh-republic">City of Manila &nbsp;·&nbsp; Fourth District</div>
            <div class="lh-barangay">Barangay 419</div>
            <div class="lh-city">Barangay Hall, Zone 43, District IV, Manila</div>
            <div class="lh-office">Office of the Barangay Captain</div>
        </div>
        <img src="{{ asset('images/brgy_logo.png') }}" alt="Barangay 419 Seal">
    </div>

    <hr class="rule-thick">
    <hr class="rule-thin">

    {{-- ── Document Title ── --}}
    <div class="doc-title">
        <h2>List of Registered Residents</h2>
        <p>Official Record — For Official Use Only</p>
    </div>

    {{-- ── Meta info ── --}}
    @php
        $totalCount  = $residents->count();
        $maleCount   = $residents->where('gender', 'Male')->count();
        $femaleCount = $residents->where('gender', 'Female')->count();
        $printedBy   = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $printedAt   = now()->timezone('Asia/Manila');
        $captain     = \App\Models\User::where('role', 2)->first();
        $captainName = $captain ? strtoupper($captain->first_name . ' ' . $captain->last_name) : 'BARANGAY CAPTAIN';
    @endphp

    <div class="meta-row">
        <span><span class="meta-label">Date Printed:</span> {{ $printedAt->format('F d, Y') }}</span>
        <span><span class="meta-label">Time:</span> {{ $printedAt->format('h:i A') }}</span>
        <span><span class="meta-label">Prepared by:</span> {{ $printedBy }}</span>
        <span><span class="meta-label">Document No.:</span> BRY419-RL-{{ $printedAt->format('Ymd') }}</span>
    </div>

    {{-- ── Summary counts ── --}}
    <div class="stats-row">
        <div class="stat">
            <div class="sv">{{ $totalCount }}</div>
            <div class="sl">Total Residents</div>
        </div>
        <div class="stat">
            <div class="sv">{{ $maleCount }}</div>
            <div class="sl">Male</div>
        </div>
        <div class="stat">
            <div class="sv">{{ $femaleCount }}</div>
            <div class="sl">Female</div>
        </div>
        <div class="stat">
            <div class="sv">{{ $residents->whereNotNull('birth_date')->filter(fn($r) => \Carbon\Carbon::parse($r->birth_date)->age < 18)->count() }}</div>
            <div class="sl">Minors (Below 18)</div>
        </div>
        <div class="stat">
            <div class="sv">{{ $residents->whereNotNull('birth_date')->filter(fn($r) => \Carbon\Carbon::parse($r->birth_date)->age >= 60)->count() }}</div>
            <div class="sl">Senior Citizens (60+)</div>
        </div>
    </div>

    {{-- ── Residents Table ── --}}
    <table>
        <thead>
            <tr>
                <th class="center" style="width:24px;">No.</th>
                <th style="width:28%;">Name</th>
                <th class="center">Sex</th>
                <th class="center">Age</th>
                <th class="center">Civil Status</th>
                <th class="center">Birth Date</th>
                <th>Address</th>
                <th>Contact No.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($residents as $i => $r)
            <tr>
                <td class="row-num">{{ $i + 1 }}</td>
                <td>
                    <div class="res-name">{{ strtoupper($r->last_name) }}, {{ $r->first_name }}{{ $r->middle_name ? ' ' . substr($r->middle_name, 0, 1) . '.' : '' }}{{ $r->suffix ? ' ' . $r->suffix : '' }}</div>
                    @if($r->email)
                        <div class="res-email">{{ $r->email }}</div>
                    @endif
                </td>
                <td class="center">{{ $r->gender ? strtoupper(substr($r->gender, 0, 1)) : '—' }}</td>
                <td class="center">{{ $r->age ?? '—' }}</td>
                <td class="center">{{ $r->civil_status ? ucfirst($r->civil_status) : '—' }}</td>
                <td class="center">{{ $r->birth_date ? \Carbon\Carbon::parse($r->birth_date)->format('m/d/Y') : '—' }}</td>
                <td>{{ $r->address ?: '—' }}</td>
                <td>{{ $r->phone ?: '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ── Certification ── --}}
    <div class="certification">
        This is to certify that the foregoing is a true and complete list of registered residents of
        <strong>Barangay 419, District IV, City of Manila</strong> as recorded in the Barangay database
        as of <strong>{{ $printedAt->format('F d, Y') }}</strong>, comprising a total of
        <strong>{{ $totalCount }}</strong> registered residents.
    </div>

    {{-- ── Signature ── --}}
    <div class="signature-section">
        <div class="sig-left">
            <p><strong>Prepared by:</strong></p>
            <p>{{ $printedBy }}</p>
            <p>{{ $printedAt->format('F d, Y') }}</p>
        </div>
        <div class="sig-block">
            <div class="sig-name">HON. {{ $captainName }}</div>
            <div class="sig-title">Barangay Captain</div>
            <div class="sig-label">Barangay 419, District IV, Manila</div>
        </div>
    </div>

    {{-- ── Footer ── --}}
    <div class="doc-footer">
        <span>Barangay 419 — Official Resident Registry &nbsp;|&nbsp; For Official Use Only</span>
        <span>Document Ref: BRY419-RL-{{ $printedAt->format('Ymd') }} &nbsp;|&nbsp; Page 1</span>
    </div>

</div>

<script>
    window.addEventListener('load', function () {
        setTimeout(function () { window.print(); }, 500);
    });
</script>
</body>
</html>
