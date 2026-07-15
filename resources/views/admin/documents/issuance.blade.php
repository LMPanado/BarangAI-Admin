@extends('layouts.admin')

@section('content')
@php
    $resident    = $request->resident;
    $firstName   = $resident->first_name  ?? '';
    $middleName  = $resident->middle_name ?? '';
    $lastName    = $resident->last_name   ?? '';
    $suffix      = $resident->suffix      ?? '';
    $fullName    = strtoupper(trim(
        $firstName . ' ' .
        ($middleName ? $middleName . ' ' : '') .
        $lastName .
        ($suffix ? ' ' . $suffix : '')
    )) ?: strtoupper($request->full_name ?? 'UNKNOWN');

    $address     = $resident->address      ?? $request->address ?? '';
    $age         = $resident->age          ?? null;
    $gender      = $resident->gender       ?? null;
    $civilStatus = $resident->civil_status ?? null;
    $birthDate   = $resident && $resident->birth_date
                    ? $resident->birth_date->format('F d, Y') : null;
    $birthPlace  = $resident->place_birth  ?? null;
    $heightCm    = $resident->height_cm    ?? null;
    $weightKg    = $resident->weight_kg    ?? null;
    $phone       = $resident->phone        ?? null;

    $docType     = $request->document_type ?? 'Barangay Certificate';
    $purpose     = $request->purpose       ?? '';
    $refNo       = $request->reference_no  ?? ('REF-' . str_pad($request->id, 6, '0', STR_PAD_LEFT));
    $issuedDate  = now()->format('jS') . ' day of ' . now()->format('F, Y');
    $issuedYear  = now()->year;

    $genderStr   = $gender ? strtolower($gender) : null;
    $pronounHim  = ($gender && strtolower($gender) === 'female') ? 'her' : 'him/her';
    $pronounHis  = ($gender && strtolower($gender) === 'female') ? 'her' : 'his/her';

    // Captain name from DB
    $captain     = \App\Models\User::where('role', 2)->first();
    $captainName = $captain
        ? strtoupper(trim(($captain->first_name ?? '') . ' ' . ($captain->last_name ?? '')))
        : 'ERWIN R. MOLINA';

    $templates = [
        'Barangay Clearance' => [
            'title'  => 'BARANGAY CLEARANCE',
            'body'   => "This is to certify that <strong><em>{$fullName}</em></strong>"
                      . ($age    ? ", {$age} years of age"   : ', of legal age')
                      . ($genderStr ? ", {$genderStr}"       : '')
                      . ($civilStatus ? ", {$civilStatus}"   : '')
                      . ", Filipino citizen, and a bona fide resident of <strong><em>{$address}</em></strong>, Barangay 419, Zone 43, Sampaloc, Manila, is personally known to this office and is a person of <strong>GOOD MORAL CHARACTER</strong> and has no derogatory record on file against {$pronounHim} in this Barangay.",
            'footer' => 'This clearance is being issued upon the request of the above-named person for the purpose of',
        ],
        'Certificate of Residency' => [
            'title'  => 'CERTIFICATE OF RESIDENCY',
            'body'   => "This is to certify that <strong><em>{$fullName}</em></strong>"
                      . ($age    ? ", {$age} years of age"   : ', of legal age')
                      . ($genderStr ? ", {$genderStr}"       : '')
                      . ($civilStatus ? ", {$civilStatus}"   : '')
                      . ", Filipino citizen, is a <strong>BONA FIDE RESIDENT</strong> of <strong><em>{$address}</em></strong>, Barangay 419, Zone 43, Sampaloc, Manila, as verified from the official records of this office.",
            'footer' => 'This certification is issued upon the request of the above-named person for the purpose of',
        ],
        'Certificate of Indigency' => [
            'title'  => 'CERTIFICATE OF INDIGENCY',
            'body'   => "This is to certify that <strong><em>{$fullName}</em></strong>"
                      . ($age    ? ", {$age} years of age"   : ', of legal age')
                      . ($genderStr ? ", {$genderStr}"       : '')
                      . ($civilStatus ? ", {$civilStatus}"   : '')
                      . ", Filipino citizen, and a resident of <strong><em>{$address}</em></strong>, Barangay 419, Zone 43, Sampaloc, Manila, belongs to the <strong>INDIGENT SECTOR</strong> of this Barangay and does not have sufficient income to support {$pronounHis} daily needs.",
            'footer' => 'This certification is issued upon the request of the above-named person for the purpose of',
        ],
        'Business Permit' => [
            'title'  => 'BARANGAY BUSINESS PERMIT CLEARANCE',
            'body'   => "This is to certify that <strong><em>{$fullName}</em></strong>, a resident of <strong><em>{$address}</em></strong>, Barangay 419, Zone 43, Sampaloc, Manila, has been granted <strong>CLEARANCE TO OPERATE A BUSINESS</strong> within the jurisdiction of this Barangay, subject to compliance with all applicable city ordinances and barangay regulations.",
            'footer' => 'This permit is issued upon the request of the above-named person for the purpose of',
        ],
        'Barangay Certificate' => [
            'title'  => 'BARANGAY CERTIFICATE',
            'body'   => "This is to certify that <strong><em>{$fullName}</em></strong>"
                      . ($age    ? ", {$age} years of age"   : ', of legal age')
                      . ($genderStr ? ", {$genderStr}"       : '')
                      . ($civilStatus ? ", {$civilStatus}"   : '')
                      . ", Filipino citizen, and a resident of <strong><em>{$address}</em></strong>, Barangay 419, Zone 43, Sampaloc, Manila, is known to this office and is a <strong>LAW-ABIDING CITIZEN</strong> of this community.",
            'footer' => 'This certification is issued upon the request of the above-named person for the purpose of',
        ],
        'Barangay ID' => [
            'title'  => 'BARANGAY IDENTIFICATION CARD',
            'body'   => '',
            'footer' => '',
        ],
    ];

    $tpl          = $templates[$docType] ?? $templates['Barangay Certificate'];
    $templateKeys = array_keys($templates);
    $isIdCard     = ($docType === 'Barangay ID');
@endphp

{{-- html2pdf.js — free client-side PDF export --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>

<style>
/* ── Screen helpers ── */
.print-only { display: none !important; }
[contenteditable]:focus        { outline: 2px dashed #2563eb; outline-offset: 2px; background: #eff6ff; border-radius: 2px; }
[contenteditable]:hover:not(:focus) { background: #f0fdf4; border-radius: 2px; cursor: text; }

/* ── Print media ── */
@media print {
    .no-print,
    #admin-sidebar, nav, header, aside,
    [class*="sidebar"], [class*="topbar"] { display: none !important; }

    body, html { background: white !important; margin: 0 !important; padding: 0 !important; }

    /* Hide both by default; body class reveals the active one */
    #certificate-area, #id-card-area { display: none !important; }

    body.print-cert #certificate-area {
        display: block !important;
        position: fixed !important;
        inset: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
        border: none !important;
    }
    body.print-id #id-card-area {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        position: fixed !important;
        inset: 0 !important;
        background: white !important;
        padding: 0.5in !important;
    }
    .id-card { box-shadow: none !important; border: 1px solid #aaa !important; }
    .print-only { display: block !important; }
}

/* ── Certificate document styles ── */
#certificate-area {
    font-family: 'Times New Roman', Times, serif;
    background: white;
    color: #111;
}

/* Outer decorative border */
.cert-outer-border {
    border: 3px double #1a3a6e;
    padding: 6px;
    min-height: 9.5in;
    position: relative;
}
.cert-inner-border {
    border: 1px solid #1a3a6e;
    padding: 0.6in 0.75in 0.5in;
    min-height: calc(9.5in - 16px);
    position: relative;
}

/* Corner ornaments */
.cert-inner-border::before,
.cert-inner-border::after {
    content: '✦';
    position: absolute;
    font-size: 10px;
    color: #1a3a6e;
    line-height: 1;
}
.cert-inner-border::before { top: 6px; left: 8px; }
.cert-inner-border::after  { bottom: 6px; right: 8px; }

/* Letterhead */
.cert-letterhead {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
    gap: 12px;
}
.cert-seal {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.cert-seal img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.cert-header-text {
    text-align: center;
    flex: 1;
    font-family: 'Times New Roman', Times, serif;
}
.cert-header-text .republic {
    font-size: 9.5pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #1a3a6e;
    margin: 0;
}
.cert-header-text .ncr {
    font-size: 8pt;
    color: #4b5563;
    margin: 2px 0;
    letter-spacing: 0.05em;
}
.cert-header-text .brgy-name {
    font-size: 20pt;
    font-weight: 900;
    text-transform: uppercase;
    color: #1a3a6e;
    margin: 2px 0;
    letter-spacing: 0.04em;
    line-height: 1.1;
}
.cert-header-text .office-name {
    font-size: 8.5pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #374151;
    margin: 3px 0 0;
}
.cert-header-text .contact {
    font-size: 7.5pt;
    color: #6b7280;
    margin: 3px 0 0;
}

/* Thick-thin rule after letterhead */
.cert-rule-thick {
    border: none;
    border-top: 4px solid #1a3a6e;
    margin: 6px 0 0;
}
.cert-rule-thin {
    border: none;
    border-top: 1.5px solid #1a3a6e;
    margin: 2px 0 8px;
}

/* Ref/date strip */
.cert-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 8.5pt;
    color: #374151;
    margin-bottom: 20px;
    font-family: 'Times New Roman', Times, serif;
}

/* Document title */
.cert-doc-title {
    text-align: center;
    font-size: 16pt;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    text-decoration: underline;
    color: #1a1a1a;
    margin: 18px 0 24px;
    font-family: 'Times New Roman', Times, serif;
}

/* Greeting */
.cert-greeting {
    font-size: 11pt;
    font-weight: bold;
    margin-bottom: 16px;
    font-family: 'Times New Roman', Times, serif;
}

/* Body paragraphs */
.cert-para {
    text-indent: 3em;
    text-align: justify;
    line-height: 2;
    font-size: 11pt;
    color: #1a1a1a;
    margin-bottom: 14px;
    font-family: 'Times New Roman', Times, serif;
}

/* Signature block */
.cert-sig-block {
    margin-top: 48px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 16px;
}
.cert-sig-item {
    text-align: center;
}
.cert-sig-line-box {
    width: 180px;
    height: 52px;
    border: 1px dashed #d1d5db;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding-bottom: 4px;
    margin-bottom: 0;
}
.cert-sig-line-box span {
    font-size: 7pt;
    font-family: sans-serif;
    color: #d1d5db;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.cert-sig-label {
    border-top: 2px solid #374151;
    padding-top: 4px;
    width: 180px;
}
.cert-sig-label .sig-name {
    font-size: 11pt;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #111;
    margin: 0 0 1px;
    font-family: 'Times New Roman', Times, serif;
}
.cert-sig-label .sig-title {
    font-size: 8.5pt;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #4b5563;
    margin: 0;
    font-family: sans-serif;
}
.cert-sig-label.wide { width: 210px; }
.cert-sig-line-box.wide { width: 210px; }

/* Dry seal note */
.cert-seal-note {
    text-align: center;
    font-size: 8pt;
    color: #9ca3af;
    margin-top: 6px;
    font-style: italic;
    font-family: sans-serif;
}

/* OR/CTC footer strip */
.cert-or-strip {
    margin-top: 28px;
    padding-top: 8px;
    border-top: 1px solid #d1d5db;
    display: flex;
    justify-content: space-between;
    font-size: 8.5pt;
    color: #6b7280;
    font-family: 'Times New Roman', Times, serif;
}

/* ── ID Card styles (unchanged) ── */
.id-card {
    width: 3.375in; height: 2.125in; border-radius: 8px; overflow: hidden;
    font-family: Arial, sans-serif; border: 1px solid #d1d5db;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12); display: flex;
    flex-direction: column; flex-shrink: 0;
}
.id-front-header {
    background: linear-gradient(135deg,#1d4ed8,#1e40af); color:white;
    padding:5px 8px 4px; display:flex; align-items:center; gap:6px;
}
.id-front-header .seal-circle {
    width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,.2);
    border:1px solid rgba(255,255,255,.4);display:flex;align-items:center;
    justify-content:center;flex-shrink:0;overflow:hidden;
}
.id-front-header .seal-circle img { width:100%;height:100%;object-fit:contain; }
.id-front-header .hdr-text { flex:1;text-align:center; }
.id-front-header .hdr-text p { margin:0;line-height:1.2; }
.id-front-header .hdr-text .brgy-nm { font-size:8px;font-weight:900;letter-spacing:.05em; }
.id-front-header .hdr-text .brgy-lc { font-size:6px;font-weight:600;opacity:.85; }
.id-card-title-bar { background:#fbbf24;text-align:center;padding:2px 4px;font-size:6.5px;font-weight:900;letter-spacing:.15em;text-transform:uppercase;color:#1e3a5f; }
.id-front-body { flex:1;display:flex;padding:6px 8px;gap:8px;background:white; }
.id-photo-box { width:52px;height:64px;border:1.5px solid #d1d5db;border-radius:4px;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f9fafb;flex-shrink:0; }
.id-photo-box svg { color:#d1d5db; }
.id-photo-box span { font-size:5px;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-top:2px; }
.id-info { flex:1;display:flex;flex-direction:column;justify-content:center;gap:3px; }
.id-info .id-name { font-size:8.5px;font-weight:900;color:#111827;text-transform:uppercase;line-height:1.2; }
.id-info .id-field { font-size:6px;color:#374151;line-height:1.4; }
.id-info .id-field span { color:#6b7280; }
.id-front-footer { background:#f3f4f6;border-top:1px solid #e5e7eb;padding:3px 8px;display:flex;justify-content:space-between;align-items:center; }
.id-front-footer p { margin:0;font-size:5.5px;color:#6b7280;letter-spacing:.05em; }
.id-front-footer .id-no { font-weight:900;color:#1d4ed8;font-family:monospace;font-size:6px; }
.id-back { display:flex;flex-direction:column; }
.id-back-header { background:linear-gradient(135deg,#1d4ed8,#1e40af);color:white;text-align:center;padding:4px; }
.id-back-header p { margin:0;font-size:6px;letter-spacing:.1em;font-weight:700; }
.id-back-body { flex:1;padding:6px 10px;background:white;display:flex;flex-direction:column;justify-content:space-between; }
.id-back-body .ec-title { font-size:5.5px;font-weight:900;color:#374151;text-transform:uppercase;letter-spacing:.1em;margin-bottom:3px; }
.id-back-body .ec-line { display:flex;align-items:center;gap:4px;margin-bottom:2px; }
.id-back-body .ec-label { font-size:5.5px;color:#6b7280;width:50px;flex-shrink:0; }
.id-back-body .ec-value { flex:1;border-bottom:.5px solid #9ca3af;font-size:5.5px;color:#111827;padding-bottom:1px;min-width:0; }
.id-sig-block { display:flex;justify-content:center; }
.id-sig-block .sig-inner { text-align:center; }
.id-sig-block .sig-line { width:80px;border-top:1px solid #111827;padding-top:2px; }
.id-sig-block .sig-name { font-size:6px;font-weight:900;color:#111827;letter-spacing:.05em;text-transform:uppercase; }
.id-sig-block .sig-title { font-size:5px;color:#6b7280;text-transform:uppercase;letter-spacing:.05em; }
.id-back-footer { background:#1d4ed8;color:white;text-align:center;padding:2px;font-size:5.5px;letter-spacing:.08em;font-weight:700; }
</style>

<div class="space-y-6">

    {{-- ── Admin page header (no-print) ── --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6 no-print">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Generate Document</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">
                Issuing <span class="text-brgyGreen font-bold">{{ $docType }}</span> for
                <span class="font-bold text-gray-700">{{ $fullName }}</span>
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <a href="{{ route('admin.documents.index') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Requests</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Generate</span>
        </nav>
    </div>

    <div class="flex gap-8 items-start">

        {{-- ── SIDEBAR (no-print) ── --}}
        <div class="w-64 shrink-0 space-y-5 no-print">

            {{-- Requester Info --}}
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Requester Info</p>
                <div class="space-y-2 text-xs">
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Name</p>
                        <p class="font-bold text-gray-800">{{ $fullName }}</p>
                    </div>
                    @if($address)
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Address</p>
                        <p class="text-gray-600">{{ $address }}</p>
                    </div>
                    @endif
                    @if($age)
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Age</p>
                        <p class="text-gray-600">{{ $age }}</p>
                    </div>
                    @endif
                    @if($civilStatus)
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Civil Status</p>
                        <p class="text-gray-600">{{ $civilStatus }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Reference No.</p>
                        <p class="font-bold text-brgyGreen font-mono">{{ $refNo }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Purpose</p>
                        <p class="text-gray-600 italic">"{{ $purpose }}"</p>
                    </div>
                </div>
            </div>

            {{-- Print / PDF --}}
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 space-y-3">
                <button onclick="window.print()"
                        class="w-full bg-brgyGreen text-white font-black text-[10px] uppercase tracking-widest py-3.5 rounded-2xl hover:shadow-lg hover:shadow-brgyGreen/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Document
                </button>
                <button onclick="downloadPdf()"
                        class="w-full bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest py-3.5 rounded-2xl hover:shadow-lg hover:shadow-blue-600/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF
                </button>
                <p class="text-[9px] text-gray-300 text-center font-bold uppercase tracking-widest" id="paper-size-hint">Letter / A4 size</p>
                <p class="text-[9px] text-gray-400 text-center leading-relaxed mt-1">
                    <svg class="w-3 h-3 inline text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Click any highlighted text to edit before printing.
                </p>
            </div>
        </div>

        {{-- ══════════════════════════════════════
             CERTIFICATE AREA
        ══════════════════════════════════════ --}}
        <div id="certificate-area"
             style="flex:1; max-width:8.5in; padding:0.4in 0.5in; {{ $isIdCard ? 'display:none' : '' }}">

            <div class="cert-outer-border">
                <div class="cert-inner-border">

                    {{-- ── Letterhead ── --}}
                    <div class="cert-letterhead">
                        {{-- Manila seal --}}
                        <div class="cert-seal">
                            <img src="{{ asset('images/manila-seal.png') }}" alt="Manila Seal"
                                 onerror="this.style.opacity='0';">
                        </div>

                        {{-- Center text --}}
                        <div class="cert-header-text">
                            <p class="republic">Republic of the Philippines</p>
                            <p class="ncr">National Capital Region &bull; City of Manila</p>
                            <p class="brgy-name">Barangay 419, Zone 43</p>
                            <p class="ncr" style="font-size:8.5pt; margin:1px 0;">Sampaloc, Manila</p>
                            <p class="office-name">Office of the Punong Barangay</p>
                            <p class="contact">Tel. (02) 000-0000 &nbsp;&bull;&nbsp; brgy419sampaloc.cloud</p>
                        </div>

                        {{-- Barangay seal --}}
                        <div class="cert-seal">
                            <img src="{{ asset('images/barangay-seal.png') }}" alt="Barangay Seal"
                                 onerror="this.style.opacity='0';">
                        </div>
                    </div>

                    {{-- Thick-thin rule --}}
                    <hr class="cert-rule-thick">
                    <hr class="cert-rule-thin">

                    {{-- Ref / Date --}}
                    <div class="cert-meta">
                        <span>Ref. No.:&nbsp;<strong>{{ $refNo }}</strong></span>
                        <span>Date:&nbsp;<strong>{{ now()->timezone('Asia/Manila')->format('F d, Y') }}</strong></span>
                    </div>

                    {{-- Document Title --}}
                    <div id="doc-title" class="cert-doc-title" contenteditable="true">{{ $tpl['title'] }}</div>

                    {{-- Body --}}
                    <p class="cert-greeting">TO WHOM IT MAY CONCERN:</p>

                    <p id="doc-body" class="cert-para" contenteditable="true">{!! $tpl['body'] !!}</p>

                    <p class="cert-para" id="doc-footer" contenteditable="true">{{ $tpl['footer'] }}
                        <span id="doc-purpose"
                              style="border-bottom:1px solid #374151; padding:0 4px; font-weight:bold; font-style:italic;">{{ $purpose ?: 'general purposes' }}</span>
                        and for whatever legal purpose it may serve.
                    </p>

                    <p class="cert-para">
                        Issued this <strong>{{ $issuedDate }}</strong> at the Office of the Punong Barangay, Barangay 419, Zone 43, Sampaloc, Manila, Philippines.
                    </p>

                    {{-- Signature Block --}}
                    <div class="cert-sig-block">

                        {{-- Requestor --}}
                        <div class="cert-sig-item">
                            <div class="cert-sig-line-box">
                                <span>Signature over Printed Name</span>
                            </div>
                            <div class="cert-sig-label">
                                <p class="sig-title">Requestor</p>
                            </div>
                        </div>

                        {{-- Dry Seal placeholder --}}
                        <div class="cert-sig-item" style="text-align:center;">
                            <div style="width:90px;height:90px;border:1.5px dashed #d1d5db;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                                <p style="font-size:6.5pt;color:#d1d5db;text-transform:uppercase;letter-spacing:.06em;font-family:sans-serif;text-align:center;line-height:1.4;margin:0;">Official<br>Dry Seal</p>
                            </div>
                        </div>

                        {{-- Barangay Captain --}}
                        <div class="cert-sig-item">
                            <div class="cert-sig-line-box wide" style="border:none;"></div>
                            <div class="cert-sig-label wide">
                                <p class="sig-name">{{ $captainName }}</p>
                                <p class="sig-title">Punong Barangay</p>
                            </div>
                        </div>

                    </div>

                    <p class="cert-seal-note">Not valid without the Official Dry Seal of Barangay 419</p>

                    {{-- OR / CTC Strip --}}
                    <div class="cert-or-strip">
                        <span>OR No.: ________________________</span>
                        <span>Amount Paid: Php ______________</span>
                        <span>CTC No.: _______________________</span>
                    </div>

                </div>{{-- end inner-border --}}
            </div>{{-- end outer-border --}}

        </div>{{-- end certificate-area --}}

        {{-- ══════════════════════════════════════
             ID CARD AREA
        ══════════════════════════════════════ --}}
        <div id="id-card-area"
             class="flex-1 flex flex-col items-center justify-center gap-6 py-8"
             style="{{ $isIdCard ? '' : 'display:none' }}">

            <p class="no-print text-[10px] font-black text-gray-300 uppercase tracking-widest">
                Preview — prints at standard ID card size (3.375&Prime; × 2.125&Prime;)
            </p>

            <div style="display:flex; gap:24px; align-items:flex-start;">

                {{-- FRONT --}}
                <div>
                    <p class="no-print text-[9px] font-black text-gray-400 uppercase tracking-widest text-center mb-2">Front</p>
                    <div class="id-card">
                        <div class="id-front-header">
                            <div class="seal-circle">
                                <img src="{{ asset('images/manila-seal.png') }}" alt="Manila" onerror="this.style.display='none';">
                            </div>
                            <div class="hdr-text">
                                <p class="brgy-nm">Barangay 419, Zone 43</p>
                                <p class="brgy-lc">Sampaloc, Manila &bull; NCR</p>
                            </div>
                            <div class="seal-circle">
                                <img src="{{ asset('images/barangay-seal.png') }}" alt="Brgy" onerror="this.style.display='none';">
                            </div>
                        </div>
                        <div class="id-card-title-bar">Barangay Identification Card</div>
                        <div class="id-front-body">
                            <div class="id-photo-box">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Photo</span>
                            </div>
                            <div class="id-info">
                                <div class="id-name">{{ $fullName }}</div>
                                @if($address)<div class="id-field"><span>Address: </span>{{ Str::limit($address, 55) }}</div>@endif
                                @if($birthDate)<div class="id-field"><span>Birthdate: </span>{{ $birthDate }}</div>@endif
                                @if($gender)<div class="id-field"><span>Sex: </span>{{ ucfirst($gender) }}</div>@endif
                                <div class="id-field" style="display:flex;gap:8px;">
                                    @if($heightCm)<span><span style="color:#9ca3af;">Ht: </span>{{ $heightCm }} cm</span>@endif
                                    @if($weightKg)<span><span style="color:#9ca3af;">Wt: </span>{{ $weightKg }} kg</span>@endif
                                </div>
                                <div class="id-field"><span>Blood Type: </span>___</div>
                            </div>
                        </div>
                        <div class="id-front-footer">
                            <p>ID No.: <span class="id-no">{{ $refNo }}</span></p>
                            <p>Valid Until: <strong style="color:#374151;font-size:5.5px;">{{ now()->format('m/d/') . ($issuedYear + 1) }}</strong></p>
                        </div>
                    </div>
                </div>

                {{-- BACK --}}
                <div>
                    <p class="no-print text-[9px] font-black text-gray-400 uppercase tracking-widest text-center mb-2">Back</p>
                    <div class="id-card id-back">
                        <div class="id-back-header"><p>Republic of the Philippines &bull; City of Manila</p></div>
                        <div class="id-back-body">
                            <div>
                                <div class="ec-title">In Case of Emergency, Notify:</div>
                                <div class="ec-line"><span class="ec-label">Name:</span><span class="ec-value"></span></div>
                                <div class="ec-line"><span class="ec-label">Relationship:</span><span class="ec-value"></span></div>
                                <div class="ec-line"><span class="ec-label">Contact No.:</span><span class="ec-value"></span></div>
                                <div class="ec-line" style="margin-top:2px;"><span class="ec-label">Blood Type:</span><span class="ec-value"></span></div>
                            </div>
                            <div class="id-sig-block">
                                <div class="sig-inner">
                                    <div style="height:18px;"></div>
                                    <div class="sig-line">
                                        <p class="sig-name">{{ $captainName }}</p>
                                        <p class="sig-title">Punong Barangay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="id-back-footer">NOT VALID WITHOUT OFFICIAL SEAL &bull; NOT TRANSFERABLE</div>
                    </div>
                </div>

            </div>
        </div>{{-- end id-card-area --}}

    </div>{{-- end flex --}}
</div>{{-- end space-y-6 --}}

<script>
const templates   = @json($templates);
const currentType = @json($docType);

function switchTemplate(type) {
    const isId = type === 'Barangay ID';

    document.getElementById('certificate-area').style.display = isId ? 'none' : '';
    document.getElementById('id-card-area').style.display     = isId ? ''     : 'none';
    document.getElementById('paper-size-hint').textContent    = isId ? 'ID card size (3.375″ × 2.125″)' : 'Letter / A4 size';

    document.body.classList.remove('print-cert', 'print-id');
    document.body.classList.add(isId ? 'print-id' : 'print-cert');

    if (!isId && templates[type]) {
        document.getElementById('doc-title').innerText = templates[type].title;
        document.getElementById('doc-body').innerHTML  = templates[type].body;

        const footer      = document.getElementById('doc-footer');
        const prevPurpose = document.getElementById('doc-purpose');
        const purposeText = prevPurpose ? prevPurpose.innerText : '';
        footer.innerHTML  = '';
        footer.appendChild(document.createTextNode(templates[type].footer + ' '));
        const span = document.createElement('span');
        span.id = 'doc-purpose';
        span.style.cssText = 'border-bottom:1px solid #374151;padding:0 4px;font-weight:bold;font-style:italic;';
        span.innerText = purposeText;
        footer.appendChild(span);
        footer.appendChild(document.createTextNode(' and for whatever legal purpose it may serve.'));
    }

    document.querySelectorAll('[id^="btn-"]').forEach(btn => {
        btn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-gray-50 text-gray-600 hover:bg-gray-100';
    });
    const slug = type.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const activeBtn = document.getElementById('btn-' + slug);
    if (activeBtn) {
        activeBtn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-brgyGreen text-white shadow-md';
    }
}

function downloadPdf() {
    const isId  = document.body.classList.contains('print-id');
    const el    = document.getElementById(isId ? 'id-card-area' : 'certificate-area');
    const title = document.getElementById('doc-title')?.innerText?.trim() || (isId ? 'Barangay_ID' : 'Document');
    const refNo = @json($refNo);

    html2pdf().set({
        margin:      0,
        filename:    title.replace(/\s+/g, '_') + '_' + refNo + '.pdf',
        image:       { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, logging: false },
        jsPDF:       { unit: 'in', format: isId ? [4.5, 3] : 'letter', orientation: 'portrait' },
    }).from(el).save();
}

document.addEventListener('DOMContentLoaded', () => switchTemplate(currentType));
</script>

@endsection
