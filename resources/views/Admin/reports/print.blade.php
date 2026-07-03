<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Barangay 419 — Monthly Report {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; background: white; padding: 32px 40px; }
  @page { size: A4 portrait; margin: 12mm 15mm; }
  @media print { body { padding: 0; } .no-print { display: none !important; } }

  /* Print button */
  .no-print { text-align: center; margin-bottom: 24px; }
  .no-print button {
    background: #1d4ed8; color: white; border: none; padding: 10px 28px;
    font-size: 12px; font-weight: 700; border-radius: 8px; cursor: pointer; letter-spacing: 0.05em;
  }
  .no-print button:hover { background: #1e3a8a; }

  /* Header */
  .header { display: flex; align-items: center; gap: 18px; border-bottom: 3px solid #1d4ed8; padding-bottom: 14px; margin-bottom: 20px; }
  .header img { width: 60px; height: 60px; object-fit: contain; }
  .header-text h1 { font-size: 18px; font-weight: 900; color: #1e3a8a; text-transform: uppercase; letter-spacing: 0.06em; }
  .header-text p { font-size: 10px; color: #64748b; margin-top: 2px; }
  .header-text .month { font-size: 12px; font-weight: 800; color: #1d4ed8; margin-top: 4px; }
  .header-meta { margin-left: auto; text-align: right; font-size: 9px; color: #94a3b8; line-height: 1.8; }
  .header-meta strong { color: #475569; font-size: 10px; }

  /* Summary row */
  .summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 18px; }
  .summary-card { border-radius: 8px; padding: 12px 14px; border: 1px solid #e2e8f0; }
  .summary-card .lbl { font-size: 7.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 5px; }
  .summary-card .val { font-size: 28px; font-weight: 900; line-height: 1; }
  .summary-card .sub { font-size: 8px; color: #94a3b8; margin-top: 4px; font-weight: 600; }

  /* Grid */
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }

  /* Section card */
  .card { border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; }
  .card-head { padding: 9px 14px; display: flex; justify-content: space-between; align-items: center; }
  .card-head .title { font-size: 8.5px; font-weight: 900; color: white; text-transform: uppercase; letter-spacing: 0.18em; }
  .card-head .count { font-size: 8.5px; color: rgba(255,255,255,0.6); font-weight: 700; }
  .card-body { padding: 12px 14px; }

  /* Stat tiles */
  .tiles { display: flex; gap: 8px; margin-bottom: 10px; }
  .tile { flex: 1; border-radius: 8px; padding: 9px 6px; text-align: center; }
  .tile .num { font-size: 22px; font-weight: 900; }
  .tile .lbl { font-size: 7.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-top: 2px; }

  /* Table */
  table { width: 100%; border-collapse: collapse; }
  thead th { font-size: 8px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; padding: 5px 8px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; }
  tbody td { font-size: 10px; color: #475569; padding: 5px 8px; border-bottom: 1px solid #f1f5f9; }
  tbody td.num { font-weight: 700; color: #1e293b; text-align: center; }
  tbody td.pct { color: #94a3b8; text-align: center; }

  /* Gender bar */
  .gender-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; }
  .gender-box { text-align: center; min-width: 44px; }
  .gender-box .gnum { font-size: 22px; font-weight: 900; }
  .gender-box .glbl { font-size: 7.5px; font-weight: 800; text-transform: uppercase; color: #94a3b8; }
  .gender-bar { flex: 1; background: #f1f5f9; border-radius: 3px; height: 7px; }
  .gender-bar-fill { height: 7px; border-radius: 3px; }

  /* Section label */
  .sec-lbl { font-size: 7.5px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 6px; }

  /* Rate bar */
  .rate-row { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; padding-top: 8px; border-top: 1px solid #f1f5f9; margin-bottom: 4px; }
  .rate-lbl { font-size: 9px; color: #64748b; font-weight: 600; }
  .rate-val { font-size: 12px; font-weight: 900; color: #16a34a; }
  .bar-wrap { background: #f1f5f9; border-radius: 3px; height: 7px; }
  .bar-fill  { border-radius: 3px; height: 7px; }

  /* Footer */
  .footer { border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 18px; display: flex; justify-content: space-between; }
  .footer p { font-size: 8px; color: #94a3b8; }
</style>
</head>
<body>

@php
  $reportMonth = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
  $malePct     = $totalResidents > 0 ? round(($maleCount   / $totalResidents) * 100) : 0;
  $femalePct   = 100 - $malePct;
  $resolvedPct = $totalComplaints > 0 ? round(($closedComplaints  / $totalComplaints) * 100) : 0;
  $posPct      = $totalFeedback   > 0 ? round(($positiveFeedback  / $totalFeedback)   * 100) : 0;
@endphp

<div class="no-print">
  <button onclick="window.print()">&#128438; Print / Save as PDF</button>
</div>

<!-- Header -->
<div class="header">
  <img src="{{ asset('images/brgy_logo.png') }}" alt="Logo">
  <div class="header-text">
    <h1>Barangay 419</h1>
    <p>Zone 43, District IV &middot; Sampaloc, Manila 1008</p>
    <p class="month">Monthly Barangay Report &mdash; {{ $reportMonth }}</p>
  </div>
  <div class="header-meta">
    <div>Generated</div>
    <strong>{{ now()->format('F d, Y') }}</strong>
    <div>{{ now()->format('h:i A') }}</div>
  </div>
</div>

<!-- Summary Cards -->
<div class="summary">
  <div class="summary-card" style="background:#eff6ff;">
    <div class="lbl">Total Residents</div>
    <div class="val" style="color:#1e3a8a;">{{ $totalResidents }}</div>
    <div class="sub">{{ $newResidents }} new this month</div>
  </div>
  <div class="summary-card" style="background:#eff6ff;">
    <div class="lbl">Document Requests</div>
    <div class="val" style="color:#1d4ed8;">{{ $allTimeDocs }}</div>
    <div class="sub">{{ $pendingDocs }} pending this month</div>
  </div>
  <div class="summary-card" style="background:#fffbeb;">
    <div class="lbl">Complaints</div>
    <div class="val" style="color:#92400e;">{{ $allTimeComplaints }}</div>
    <div class="sub">{{ $openComplaints }} open this month</div>
  </div>
  <div class="summary-card" style="background:#f0fdf4;">
    <div class="lbl">Feedback</div>
    <div class="val" style="color:#166534;">{{ $allTimeFeedback }}</div>
    <div class="sub">{{ $positiveFeedback }} positive this month</div>
  </div>
</div>

<!-- Top row -->
<div class="grid2">

  <!-- Population -->
  <div class="card">
    <div class="card-head" style="background:#1d4ed8;">
      <span class="title">Population Overview</span>
      <span class="count">{{ $totalResidents }} residents</span>
    </div>
    <div class="card-body">
      <div class="gender-row">
        <div class="gender-box">
          <div class="gnum" style="color:#2563eb;">{{ $maleCount }}</div>
          <div class="glbl">Male</div>
        </div>
        <div class="gender-bar">
          <div class="gender-bar-fill" style="background:#60a5fa;width:{{ $malePct }}%;"></div>
        </div>
        <div class="gender-box">
          <div class="gnum" style="color:#ec4899;">{{ $femaleCount }}</div>
          <div class="glbl">Female</div>
        </div>
      </div>
      <div class="sec-lbl">Age Distribution</div>
      <table>
        <thead><tr><th>Age Group</th><th style="text-align:center;">Count</th><th style="text-align:center;">Share</th></tr></thead>
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
      <p style="margin-top:8px;font-size:9px;color:#64748b;">New registrations this month: <strong style="color:#1d4ed8;">{{ $newResidents }}</strong></p>
      @endif
    </div>
  </div>

  <!-- Document Requests -->
  <div class="card">
    <div class="card-head" style="background:#1e40af;">
      <span class="title">Document Requests</span>
      <span class="count">{{ $totalDocs }} this month</span>
    </div>
    <div class="card-body">
      <div class="tiles">
        <div class="tile" style="background:#fffbeb;"><div class="num" style="color:#d97706;">{{ $pendingDocs }}</div><div class="lbl">Pending</div></div>
        <div class="tile" style="background:#f0fdf4;"><div class="num" style="color:#16a34a;">{{ $approvedDocs }}</div><div class="lbl">Approved</div></div>
        <div class="tile" style="background:#fef2f2;"><div class="num" style="color:#dc2626;">{{ $rejectedDocs }}</div><div class="lbl">Rejected</div></div>
      </div>
      @if($docsByType->isNotEmpty())
      <div class="sec-lbl" style="margin-top:4px;">By Document Type</div>
      <table>
        <thead><tr><th>Type</th><th style="text-align:center;">Count</th><th style="text-align:center;">Share</th></tr></thead>
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
      @endif
    </div>
  </div>

</div>

<!-- Bottom row -->
<div class="grid2">

  <!-- Complaints -->
  <div class="card">
    <div class="card-head" style="background:#92400e;">
      <span class="title">Complaints</span>
      <span class="count">{{ $totalComplaints }} this month</span>
    </div>
    <div class="card-body">
      <div class="tiles">
        <div class="tile" style="background:#fffbeb;"><div class="num" style="color:#d97706;">{{ $openComplaints }}</div><div class="lbl">Open</div></div>
        <div class="tile" style="background:#f0fdf4;"><div class="num" style="color:#16a34a;">{{ $closedComplaints }}</div><div class="lbl">Closed</div></div>
        <div class="tile" style="background:#fef2f2;"><div class="num" style="color:#dc2626;">{{ $criticalComplaints }}</div><div class="lbl">Critical</div></div>
      </div>
      @if($totalComplaints > 0)
      <div class="rate-row">
        <span class="rate-lbl">Resolution Rate</span>
        <span class="rate-val">{{ $resolvedPct }}%</span>
      </div>
      <div class="bar-wrap"><div class="bar-fill" style="background:#22c55e;width:{{ $resolvedPct }}%;"></div></div>
      @endif
    </div>
  </div>

  <!-- Feedback -->
  <div class="card">
    <div class="card-head" style="background:#166534;">
      <span class="title">Resident Feedback</span>
      <span class="count">{{ $totalFeedback }} this month</span>
    </div>
    <div class="card-body">
      <div class="tiles">
        <div class="tile" style="background:#f0fdf4;"><div class="num" style="color:#16a34a;">{{ $positiveFeedback }}</div><div class="lbl">Positive</div></div>
        <div class="tile" style="background:#fef2f2;"><div class="num" style="color:#dc2626;">{{ $negativeFeedback }}</div><div class="lbl">Negative</div></div>
      </div>
      @if($totalFeedback > 0)
      <div class="rate-row">
        <span class="rate-lbl">Satisfaction Rate</span>
        <span class="rate-val">{{ $posPct }}%</span>
      </div>
      <div class="bar-wrap"><div class="bar-fill" style="background:#22c55e;width:{{ $posPct }}%;"></div></div>
      @endif
    </div>
  </div>

</div>

<!-- Footer -->
<div class="footer">
  <p>Generated from the Barangay 419 Admin Portal</p>
  <p>{{ now()->format('F d, Y \a\t h:i A') }}</p>
</div>

<script>
  // Auto-open print dialog when the page loads
  window.addEventListener('load', function() { window.print(); });
</script>
</body>
</html>
