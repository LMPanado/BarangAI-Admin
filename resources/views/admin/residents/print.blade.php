<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residents List — Barangay 419</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
            padding: 24px 32px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 2px solid #166534;
            padding-bottom: 14px;
            margin-bottom: 16px;
        }
        .header-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        .header-text h1 {
            font-size: 18px;
            font-weight: 900;
            color: #166534;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .header-text p {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .header-meta {
            margin-left: auto;
            text-align: right;
            font-size: 9px;
            color: #94a3b8;
            line-height: 1.6;
        }

        /* ── Summary stats ── */
        .stats {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }
        .stat-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 16px;
            text-align: center;
            min-width: 90px;
        }
        .stat-box .val { font-size: 20px; font-weight: 900; color: #166534; }
        .stat-box .lbl { font-size: 8px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }
        thead tr {
            background: #166534;
            color: #fff;
        }
        thead th {
            padding: 7px 8px;
            text-align: left;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            white-space: nowrap;
        }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody td {
            padding: 6px 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        .name { font-weight: 700; color: #1e293b; }
        .sub  { font-size: 8.5px; color: #94a3b8; margin-top: 1px; }
        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-male   { background: #dbeafe; color: #1d4ed8; }
        .badge-female { background: #fce7f3; color: #be185d; }

        /* ── Footer ── */
        .footer {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            font-size: 8.5px;
            color: #94a3b8;
        }
        .signature-block {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-line {
            text-align: center;
            width: 220px;
        }
        .signature-line hr {
            border: none;
            border-top: 1px solid #1e293b;
            margin-bottom: 4px;
        }
        .signature-line .sig-name  { font-weight: 900; font-size: 10px; }
        .signature-line .sig-title { font-size: 8.5px; color: #64748b; }

        @media print {
            body { padding: 16px; }
            .no-print { display: none !important; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body>

    {{-- Print button — hidden when printing --}}
    <div class="no-print" style="margin-bottom:16px; display:flex; gap:10px;">
        <button onclick="window.print()"
            style="background:#166534;color:#fff;border:none;padding:10px 24px;border-radius:8px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.1em;cursor:pointer;">
            🖨 Print
        </button>
        <button onclick="window.close()"
            style="background:#f1f5f9;color:#64748b;border:none;padding:10px 24px;border-radius:8px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.1em;cursor:pointer;">
            Close
        </button>
    </div>

    {{-- Header --}}
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" class="header-logo" alt="Barangay 419 Logo"
             onerror="this.style.display='none'">
        <div class="header-text">
            <h1>Barangay 419</h1>
            <p>District IV, Manila — Official Resident Registry</p>
        </div>
        <div class="header-meta">
            <div><strong>Printed by:</strong> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div><strong>Date:</strong> {{ now()->timezone('Asia/Manila')->format('F d, Y') }}</div>
            <div><strong>Time:</strong> {{ now()->timezone('Asia/Manila')->format('h:i A') }}</div>
            <div><strong>Total Records:</strong> {{ $residents->count() }}</div>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $totalCount  = $residents->count();
        $maleCount   = $residents->where('gender', 'Male')->count();
        $femaleCount = $residents->where('gender', 'Female')->count();
    @endphp
    <div class="stats">
        <div class="stat-box">
            <div class="val">{{ $totalCount }}</div>
            <div class="lbl">Total</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#1d4ed8;">{{ $maleCount }}</div>
            <div class="lbl">Male</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#be185d;">{{ $femaleCount }}</div>
            <div class="lbl">Female</div>
        </div>
    </div>

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                <th style="width:28px;">#</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Civil Status</th>
                <th>Birth Date</th>
                <th>Address</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            @foreach($residents as $i => $r)
            <tr>
                <td style="color:#94a3b8; font-weight:700;">{{ $i + 1 }}</td>
                <td>
                    <div class="name">{{ strtoupper($r->last_name) }}, {{ $r->first_name }}{{ $r->middle_name ? ' ' . $r->middle_name : '' }}{{ $r->suffix ? ' ' . $r->suffix : '' }}</div>
                    <div class="sub">{{ $r->email }}</div>
                </td>
                <td>
                    <span class="badge {{ $r->gender === 'Female' ? 'badge-female' : 'badge-male' }}">
                        {{ $r->gender ?? '—' }}
                    </span>
                </td>
                <td>{{ $r->age ?? '—' }}</td>
                <td>{{ $r->civil_status ?? '—' }}</td>
                <td>{{ $r->birth_date ? \Carbon\Carbon::parse($r->birth_date)->format('M d, Y') : '—' }}</td>
                <td>{{ $r->address ?? '—' }}</td>
                <td>{{ $r->phone ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Signature --}}
    <div class="signature-block">
        <div class="signature-line">
            <hr>
            <div class="sig-name">{{ strtoupper(auth()->user()->first_name . ' ' . auth()->user()->last_name) }}</div>
            <div class="sig-title">Barangay Captain, Barangay 419</div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <span>Barangay 419 — Official Resident Registry</span>
        <span>Generated: {{ now()->timezone('Asia/Manila')->format('Y-m-d H:i:s') }}</span>
    </div>

    <script>
        // Auto-trigger print dialog after page loads
        window.addEventListener('load', function () {
            // Small delay to let fonts/images settle
            setTimeout(function () { window.print(); }, 400);
        });
    </script>
</body>
</html>
