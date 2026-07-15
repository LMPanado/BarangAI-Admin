<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Blotter – #{{ $complaint->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background: #fff;
            padding: 0.5in;
        }

        /* ── Print toolbar (hidden when printing) ── */
        .no-print {
            position: fixed;
            top: 16px;
            right: 16px;
            display: flex;
            gap: 8px;
            z-index: 100;
        }
        .no-print button {
            padding: 8px 20px;
            border-radius: 8px;
            border: none;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-print { background: #1a5c2a; color: #fff; }
        .btn-print:hover { background: #166534; }
        .btn-back  { background: #f3f4f6; color: #374151; }
        .btn-back:hover  { background: #e5e7eb; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0.5in; }
            @page { margin: 0.5in; size: letter portrait; }
        }

        /* ── Document wrapper ── */
        .blotter-doc {
            max-width: 7.5in;
            margin: 0 auto;
            border: 3px double #000;
            padding: 0.4in 0.5in;
        }

        /* ── Letterhead ── */
        .letterhead {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            text-align: center;
            margin-bottom: 6pt;
        }
        .letterhead img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .letterhead .header-text {
            text-align: center;
        }
        .letterhead .republic  { font-size: 9pt; letter-spacing: 1px; }
        .letterhead .province  { font-size: 9pt; }
        .letterhead .city      { font-size: 10pt; font-weight: bold; }
        .letterhead .barangay  { font-size: 15pt; font-weight: bold; letter-spacing: 2px; }
        .letterhead .address   { font-size: 8pt; color: #444; }

        .rule-thick-thin {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 4px;
            margin: 8pt 0;
        }

        /* ── Document title ── */
        .doc-title {
            text-align: center;
            margin: 10pt 0 4pt;
        }
        .doc-title h1 {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 4px;
            text-decoration: underline;
            text-underline-offset: 3px;
        }
        .doc-title .blotter-no {
            font-size: 9pt;
            margin-top: 4pt;
        }

        /* ── Entry number & date ── */
        .entry-meta {
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
            margin: 12pt 0 8pt;
            border-bottom: 1px solid #000;
            padding-bottom: 4pt;
        }

        /* ── Section headers ── */
        .section-label {
            font-size: 9pt;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: #000;
            color: #fff;
            padding: 2pt 6pt;
            margin: 10pt 0 6pt;
            display: inline-block;
        }

        /* ── Field rows ── */
        .field-row {
            display: flex;
            gap: 0;
            margin-bottom: 6pt;
        }
        .field-row .field-label {
            font-size: 9pt;
            font-weight: bold;
            min-width: 160px;
            flex-shrink: 0;
        }
        .field-row .field-value {
            font-size: 10pt;
            border-bottom: 1px solid #000;
            flex: 1;
            padding-bottom: 1pt;
            min-height: 14pt;
        }
        .field-row .field-value[contenteditable="true"]:hover,
        .field-row .field-value[contenteditable="true"]:focus {
            background: #fef9c3;
            outline: none;
        }

        .field-row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16pt;
            margin-bottom: 6pt;
        }

        /* ── Narrative area ── */
        .narrative-area {
            border: 1px solid #000;
            min-height: 1.5in;
            padding: 8pt;
            font-size: 10pt;
            line-height: 1.8;
            margin-top: 4pt;
        }
        .narrative-area[contenteditable="true"]:hover,
        .narrative-area[contenteditable="true"]:focus {
            background: #fef9c3;
            outline: none;
        }

        /* ── Signature block ── */
        .sig-block {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20pt;
            margin-top: 30pt;
            text-align: center;
        }
        .sig-item .sig-line {
            border-top: 1px solid #000;
            margin-bottom: 4pt;
        }
        .sig-item .sig-name {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .sig-item .sig-title {
            font-size: 8pt;
        }
        .sig-item .sig-space {
            height: 40pt;
        }

        /* ── Footer ── */
        .doc-footer {
            margin-top: 16pt;
            border-top: 1px solid #000;
            padding-top: 6pt;
            font-size: 8pt;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>

{{-- Print / Back toolbar --}}
<div class="no-print">
    <button class="btn-back" onclick="history.back()">← Back</button>
    <button class="btn-print" onclick="window.print()">🖨 Print Blotter</button>
</div>

<div class="blotter-doc">

    {{-- Letterhead --}}
    <div class="letterhead">
        <img src="{{ asset('images/logo.png') }}" alt="Seal" onerror="this.style.display='none'">
        <div class="header-text">
            <p class="republic">Republic of the Philippines</p>
            <p class="province">Province of Manila</p>
            <p class="city">City of Manila</p>
            <p class="barangay">BARANGAY 419</p>
            <p class="address">Zone 41, District IV, City of Manila</p>
        </div>
        <img src="{{ asset('images/logo.png') }}" alt="Seal" onerror="this.style.display='none'">
    </div>

    <div class="rule-thick-thin"></div>

    {{-- Title --}}
    <div class="doc-title">
        <h1>BARANGAY BLOTTER</h1>
        <p class="blotter-no">Blotter Entry No.: <strong>BLT-{{ str_pad($complaint->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
    </div>

    {{-- Entry meta --}}
    <div class="entry-meta">
        <span>Date Recorded: <strong>{{ now()->timezone('Asia/Manila')->format('F d, Y') }}</strong></span>
        <span>Time Recorded: <strong>{{ now()->timezone('Asia/Manila')->format('h:i A') }}</strong></span>
        <span>Recorded by: <strong>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</strong></span>
    </div>

    {{-- Complainant --}}
    <span class="section-label">Complainant</span>

    <div class="field-row-2col">
        <div class="field-row">
            <span class="field-label">Name:</span>
            <span class="field-value" contenteditable="true">
                @if($complaint->residentUser)
                    {{ $complaint->residentUser->first_name }} {{ $complaint->residentUser->last_name }}
                @else
                    {{ $complaint->user_email }}
                @endif
            </span>
        </div>
        <div class="field-row">
            <span class="field-label">Email / Contact:</span>
            <span class="field-value" contenteditable="true">{{ $complaint->user_email }}</span>
        </div>
    </div>

    {{-- Respondent --}}
    <span class="section-label">Respondent</span>

    <div class="field-row-2col">
        <div class="field-row">
            <span class="field-label">Name:</span>
            <span class="field-value" contenteditable="true">{{ $complaint->respondent_name ?? '' }}</span>
        </div>
        <div class="field-row">
            <span class="field-label">Address:</span>
            <span class="field-value" contenteditable="true">{{ $complaint->respondent_address ?? '' }}</span>
        </div>
    </div>

    <div class="field-row">
        <span class="field-label">Resident Status:</span>
        <span class="field-value">
            @if($complaint->respondent_is_resident)
                ✔ Registered Resident of Barangay 419
            @else
                ✘ Not a Registered Resident
            @endif
        </span>
    </div>

    {{-- Incident Details --}}
    <span class="section-label">Incident Details</span>

    <div class="field-row-2col">
        <div class="field-row">
            <span class="field-label">Incident Type:</span>
            <span class="field-value" contenteditable="true">{{ $complaint->incident_type ?? '' }}</span>
        </div>
        <div class="field-row">
            <span class="field-label">Date of Incident:</span>
            <span class="field-value" contenteditable="true">
                {{ $complaint->incident_date ? $complaint->incident_date->format('F d, Y') : '' }}
            </span>
        </div>
    </div>

    <div class="field-row-2col">
        <div class="field-row">
            <span class="field-label">Time of Incident:</span>
            <span class="field-value" contenteditable="true">
                {{ $complaint->incident_time ? \Carbon\Carbon::parse($complaint->incident_time)->format('h:i A') : '' }}
            </span>
        </div>
        <div class="field-row">
            <span class="field-label">Location:</span>
            <span class="field-value" contenteditable="true">{{ $complaint->incident_location ?? '' }}</span>
        </div>
    </div>

    <div class="field-row">
        <span class="field-label">Witnesses:</span>
        <span class="field-value" contenteditable="true">{{ $complaint->witnesses ?? '' }}</span>
    </div>

    {{-- What happened (AI) --}}
    <span class="section-label">What Happened</span>
    <div class="narrative-area" contenteditable="true">{{ $whatSection }}</div>

    {{-- When --}}
    <span class="section-label">When</span>
    <div class="narrative-area" contenteditable="true" style="min-height: 0.5in; padding: 6pt 8pt;">
        @if($complaint->incident_date){{ $complaint->incident_date->format('F d, Y') }}@endif
        @if($complaint->incident_time) at {{ \Carbon\Carbon::parse($complaint->incident_time)->format('h:i A') }}@endif
    </div>

    {{-- Where --}}
    <span class="section-label">Where</span>
    <div class="narrative-area" contenteditable="true" style="min-height: 0.5in; padding: 6pt 8pt;">{{ $complaint->incident_location ?? '' }}</div>

    {{-- Signature block --}}
    <div class="sig-block">
        <div class="sig-item">
            <div class="sig-space"></div>
            <div class="sig-line"></div>
            <p class="sig-name">Complainant's Signature</p>
            <p class="sig-title">Over Printed Name</p>
        </div>
        <div class="sig-item">
            <div class="sig-space"></div>
            <div class="sig-line"></div>
            <p class="sig-name">{{ $captain ? strtoupper($captain->first_name . ' ' . $captain->last_name) : 'BARANGAY CAPTAIN' }}</p>
            <p class="sig-title">Punong Barangay</p>
        </div>
        <div class="sig-item">
            <div class="sig-space"></div>
            <div class="sig-line"></div>
            <p class="sig-name">Attending Officer</p>
            <p class="sig-title">Barangay Tanod / Secretary</p>
        </div>
    </div>

    {{-- Footer --}}
    <div class="doc-footer">
        This blotter entry is an official record of Barangay 419, City of Manila. | Entry No. BLT-{{ str_pad($complaint->id, 6, '0', STR_PAD_LEFT) }}
    </div>

</div>

</body>
</html>
